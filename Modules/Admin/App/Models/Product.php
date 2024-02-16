<?php

namespace Modules\Admin\App\Models;

// use Illuminate\Database\Eloquent\Builder;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\app\Observers\ProductObserver;
use Modules\Admin\Database\factories\ProductFactory;
use ONGR\ElasticsearchDSL\Aggregation\Metric\MinAggregation;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'category_id',
        'brand_id',
        'product_uuid',
        'product_name',
        'product_thumbnail',
        'option_name',
        'base_price',
        'sale_price',
        'sale_price_percent',
        'sale_type',
        'product_description',
        'brief_description',
        'stock',
        'status',
        'is_delete',
        'updated_by',
        'is_sale',
        'parent_product_id'
    ];

    protected $primaryKey = 'product_id';

    protected $parentId = 'parent_product_id';

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    public function toSearchableArray()
    {
        return $this->only(
            'product_id',
            'category_id',
            'brand_id',
            'product_name',
            'base_price',
            'sale_type',
            'product_description',
            'brief_description',
            'status',
            'is_delete',
            'updated_by',
            'created_at',
            'updated_at',
            'is_sale',
            'parent_product_id',
        );
    }

    public function modelObserve()
    {
        return new ProductObserver;
    }

    protected static function newFactory(): ProductFactory
    {
        return ProductFactory::new();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function options(): HasMany
    {
        return $this->hasMany(Product::class, $this->parentId);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class, $this->parentId, $this->primaryKey);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImages::class, $this->primaryKey);
    }

    public function isExistsByName(string $name, bool $excluded = false, int $id = 0)
    {
        $query = self::where('product_name', $name);

        if ($excluded) {
            $query = $query->where($this->primaryKey, '<>', $id);
        }

        return $query->exists();
    }

    public function isExistsById(int $id)
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function getList(
        bool $excluded = false,
        bool $parentFlag = true,
        bool $noChildren = false,
        int $productIdIncluded = 0
    ) {
        $query = self::where('is_delete', '<>', Constants::DESTROY);

        if ($excluded) {
            $operator = $parentFlag ? '=' : '<>';
            $query = $query->where($this->parentId, $operator, null);

            if ($noChildren) {
                $query = $query->whereNotIn('product_id', function ($q) {
                    $q->select('parent_product_id');
                    $q->from('products');
                    $q->where('parent_product_id', '<>', 'NULL');
                });
            }

            if ($productIdIncluded !== 0) {
                $query = $query->where($this->primaryKey, '<>', $productIdIncluded);
                $query = $query->orWhere($this->parentId, $productIdIncluded);
            }
        }

        return $query->get();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        $query = self::where('is_delete', '<>', Constants::DESTROY);
        $arrSearchData = array_diff_key($arrSearchData, [
            'page' => 0,
            'query' => 0
        ]);
        if (!empty($arrSearchData)) {
            // $conditions = formatQuery(array_diff_key($arrSearchData, [
            //     'priceFrom' => 0,
            //     'priceTo' => 0
            // ]));

            // $query = $query->where($conditions);

            // $query = searchBetween($query, 'base_price', data_get($arrSearchData, 'priceFrom'), data_get($arrSearchData, 'priceTo'));

            $queryString = formatQueryString(array_diff_key($arrSearchData, [
                'priceFrom' => 0,
                'priceTo' => 0,
            ]));
            $queryString = empty($queryString) ? '*' : $queryString;

            $query = searchQueryString(
                $queryString,
                $this,
                [
                    'field' => 'base_price',
                    'from' => data_get($arrSearchData, 'priceFrom'),
                    'to' => data_get($arrSearchData, 'priceTo')
                ]
            );
        }

        // return $query->orderBy('updated_at', 'DESC')
        //     ->paginate(Constants::PER_PAGE)
        //     ->withQueryString();
        return $query->orderBy('product_id', 'ASC')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();

        // return $query->paginate(Constants::PER_PAGE)
        //     ->withQueryString();
    }

    public function getDetail(int $id)
    {
        if ($this->isExistsById($id)) {
            $product = self::where($this->primaryKey, $id)->first();

            if ($product->is_delete !== Constants::DESTROY) {
                return $product;
            }
        }

        return null;
    }

    public function updateProduct(int $id, array $arrProductData)
    {
        return tap(self::where($this->primaryKey, $id))->update($arrProductData)->first();
    }

    public function removeImage(int $imageId)
    {
        if ($productImage = ProductImages::getProductId($imageId)) {
            ProductImages::where('product_images_id', $imageId)->delete();

            return $productImage->product_id;
        }

        return null;
    }

    public function clearAllOptions(int $productId)
    {
        $products = $this->getDetail($productId);

        if ($products) {
            if (is_null($products->parent_product_id)) {
                $key = $this->parentId;
            } else {
                $key = $this->primaryKey;
            }
            self::where($key, $productId)->update([
                'parent_product_id' => null,
                'option_name' => null
            ]);
        }
    }

    public function handleReport(array $arrReportData)
    {
        $productQuery = DB::table('order_detail')
            ->selectRaw('sum(order_detail.price) as product_total_prices')
            ->selectRaw('product_name as products')
            ->join('products', 'order_detail.product_id', '=', 'products.product_id');

        $result = formatQueryReport($productQuery, [
            'timeType' => $arrReportData['reportTimeType'],
            'time' => $arrReportData['timeLineReport'],
        ], 'order_detail', false, false, false);

        $query = $result['query']->groupBy('products')
            ->orderBy('product_total_prices', 'desc')
            ->get()
            ->take(10);

        return [
            'labels' => $query->pluck('products'),
            'data' => $query->pluck('product_total_prices')
        ];
    }
}
