<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\database\factories\BrandFactory;

class Brand extends Model
{
    use HasFactory;
    use Searchable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'brand_name',
        'founded',
        'brand_logo',
        'updated_by'
    ];

    protected $primaryKey = 'brand_id';

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    protected static function newFactory(): BrandFactory
    {
        return BrandFactory::new();
    }

    public function isExistsById(int $id): bool
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function isExistsByName(string $name, bool $excluded = false, int $id = 0): bool
    {
        $query = self::where('brand_name', $name);

        if ($excluded) {
            $query = $query->where($this->primaryKey, '<>', $id);
        }

        return $query->exists();
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function getList(): Collection
    {
        return self::where('is_delete', '<>', Constants::DESTROY)->get();
    }

    public function getPaginatedList(array $arrSearchData): LengthAwarePaginator
    {
        $query = self::where('is_delete', '<>', Constants::DESTROY);
        if (!empty($arrSearchData)) {
            $conditions = formatQuery(array_diff_key($arrSearchData, [
                'fromDate' => 0,
                'toDate' => 0
            ]));

            $query = $query->where($conditions);

            $query = searchBetween($query, 'founded', data_get($arrSearchData, 'fromDate'), data_get($arrSearchData, 'toDate'));
        }

        return $query->orderBy('updated_at', 'DESC')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function getDetail(int $id)
    {
        if ($this->isExistsById($id)) {
            $brand = self::where($this->primaryKey, $id)->first();

            if ($brand->is_delete !== Constants::DESTROY) {
                return $brand;
            }
        }

        return null;
    }

    public function updateBrandData(int $id, array $updateData)
    {
        $brand = $this->getDetail($id);
        if ($brand) {
            $brand->update($updateData);
            return $brand;
        }
        // return tap(self::where($this->primaryKey, $id))->update($updateData)->first();
    }

    public function updateDeleteProductState(int $brandId)
    {
        Product::where('brand_id', $brandId)->update([
            'brand_id' => null
        ]);
    }

    public function handleReport(array $arrReportData)
    {
        $productQuery = DB::table('order_detail')
            ->selectRaw('sum(order_detail.price) as product_total_prices')
            ->selectRaw('brand_name as brands')
            ->join('products', 'order_detail.product_id', '=', 'products.product_id')
            ->join('brands', 'products.brand_id', '=', 'brands.brand_id');

        $result = formatQueryReport($productQuery, [
            'timeType' => $arrReportData['reportTimeType'],
            'time' => $arrReportData['timeLineReport'],
        ], 'order_detail', false, false, false);

        $query = $result['query']->groupBy('brands')
            ->orderBy('product_total_prices', 'desc')
            ->get()
            ->take(5);

        return [
            'labels' => $query->pluck('brands'),
            'data' => $query->pluck('product_total_prices')
        ];
    }
}
