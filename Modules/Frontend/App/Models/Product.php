<?php

namespace Modules\Frontend\App\Models;

use Elastic\Elasticsearch\Client;
use Illuminate\Support\Facades\DB;
use Modules\Frontend\App\Models\Brand;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Review;
use Modules\Frontend\App\Models\Category;
use Modules\Frontend\App\Models\CartDetail;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\OrderDetail;
use Modules\Frontend\App\Models\ProductImage;
use Modules\Frontend\App\Models\OptionProduct;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\ProductFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Laravel\Scout\Searchable;
use Modules\Admin\App\Constructs\Constants;
use ONGR\ElasticsearchDSL\Search;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    const SALE_TYPE_PLAIN = 0;
    const SALE_TYPE_PERCENT = 1;

    const MAX_PRICE = 1000000000;

    const PER_PAGE_CLIENT = 25;

    protected $table = 'products';

    protected $primaryKey = 'product_id';


    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['product_name', 'product_description', 'base_price', 'product_thumbnail', 'sale_type', 'brief_description', 'stock', 'status', 'updated_by'];

    /**
     * Retrieves the brand associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 07/01/2024
     * version:1
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'brand_id');
    }

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    public function toSearchableArray()
    {
        return $this->only(
            'product_id',
            'brand_id',
            'category_id',
            'product_name',
            'base_price',
            'product_description',
            'brief_description',
            'is_delete',
            'updated_at'
        );
    }

    /**
     * Retrieve the category that the model belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 07/01/2024
     * version:1
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    /**
     * Retrieve the product images associated with this product.
     *
     * @return HasMany The product images associated with this product.
     * 07/01/2024
     * version:1
     */
    public function productImage(): HasMany
    {

        return $this->hasMany(ProductImage::class, 'product_id', 'product_id');
    }

    /**
     * Retrieve the product options for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * 07/01/2024
     * version:1
     */
    public function options(): HasMany
    {
        return $this->hasMany(OptionProduct::class, 'product_id', 'product_id');
    }

    /**
     * A method to retrieve the reviews associated with the product.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id');
    }


    public function approvedReviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'product_id')->where('is_approved', 1);
    }

    public function cartDetail(): HasMany
    {
        return $this->hasMany(CartDetail::class, 'product_id', 'product_id');
    }

    /**
     * Retrieve the order detail with its product for this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 07/01/2024
     * version:1
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_detail', 'product_id', 'order_id')
            ->withPivot('price', 'quantity')
            ->withTimestamps();
    }

    public function parentProduct(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_product_id', 'product_id');
    }


    /**
     * Retrieves a paginated list of products based on the provided query parameters.
     *
     * @param int|null $paginate The number of items to display per page.
     * @param array|null $categoryIdArray An array of category IDs to filter the products by.
     * @param array|null $brandIdArray An array of brand IDs to filter the products by.
     * @param float|null $min_price The minimum price of the products.
     * @param float|null $max_price The maximum price of the products. Defaults to the maximum allowed price.
     * @return LengthAwarePaginator The paginated list of products.

     */
    public function getProductWithQuery(array $options = [], string $searchType = 'sql'): LengthAwarePaginator
    {


        extract($options);
        $query = self::query();

        $query->whereNot('status', 0);
        $query->where('parent_product_id', null);


        if (!empty($categoryIdArr)) {
            $query->whereIn('category_id', $categoryIdArr);
        }

        if (!empty($brandIdArr)) {
            $query->whereIn('brand_id', $brandIdArr);
        }

        if ($minPrice !== null && $maxPrice !== null) {

            $query->where(function ($query) use ($minPrice, $maxPrice) {
                $query->where(function ($subquery) use ($minPrice, $maxPrice) {
                    // Filter for sale_price when sale_type is 0
                    $subquery->where('sale_type', 0)
                        ->whereBetween('sale_price', [$minPrice, $maxPrice]);
                })->orWhere(function ($subquery) use ($minPrice, $maxPrice) {
                    // Filter for derived price when sale_type is 1
                    $subquery->where('sale_type', 1)
                        ->whereBetween(
                            DB::raw('base_price - (base_price * sale_price_percent)'),
                            [$minPrice, $maxPrice]
                        );
                });
            });
        }


        if (!empty($ratingArr)) {
            $query->whereHas('reviews', function ($subquery) use ($ratingArr) {
                $subquery->select(DB::raw('ROUND(AVG(rating), 0) as avg_rating'))
                    ->groupBy('product_id')
                    ->havingRaw('avg_rating IN (' . implode(',', $ratingArr) . ')');
            });
        }

        if ($sortName === 'price') {
            $query->orderBy('base_price');
        }
        if ($sortName === 'price-desc') { // price-desc
            $query->orderBy('base_price', 'desc');
        }
        if ($sortName === 'date') {
            $query->orderBy('created_at', 'desc');
        }
        if ($sortName === 'name') {
            $query->orderBy('product_name');
        }
        if ($sortName === 'name-desc') {
            $query->orderBy('product_name', 'desc');
        }
        if ($sortName === 'rating') {
            // Order by average rating in descending order
            $query->select('products.*')
                ->selectRaw('(SELECT IFNULL(ROUND(AVG(rating), 0), 0) FROM reviews WHERE reviews.product_id = products.product_id) as avg_rating')
                ->orderByDesc('avg_rating');
        }

        if ($searchName !== null) {
            $query->where('product_name', 'like', '%' . $searchName . '%');
        }
        $query->orderBy('status');
        $query->orderBy('stock', 'desc');

        $products = $query->with('reviews')->paginate($paginate);

        return $this->_transformRatingProduct($products);
    }



    /**
     * Retrieves a single product by its ID.
     *
     * @param int $id The ID of the product to retrieve.
     * @return void
     * 10/01/2024
     * version:2
     */

    public function getSingleProduct(int $id): array
    {
        $product = self::where('product_id', $id)->with('category', 'brand', 'productImage')->first();

        if (!$product) {
            return [
                'product' => [],
                'reviews' => [],
            ];
        }

        $reviews = $product->approvedReviews()->with(["reviewImages", "user"])->paginate(4);


        $avgRating = ceil(collect($product->reviews)->avg("rating"));
        $product->rating = $avgRating ?? 0;

        return [
            'product' => $product,
            'reviews' => $reviews
        ];
    }
    /**
     * Retrieves a paginated list of related products based on the parent category ID.
     *
     * @param int $parentCategoryID The ID of the parent category.
     * @throws Some_Exception_Class Description of the exception that may be thrown.
     * @return LengthAwarePaginator The paginated list of related products.
     * 09/01/2024
     * version:1
     */
    public function getRelateProduct(int $id, int $parentCategoryID): LengthAwarePaginator
    {
        //get product with parent categories id in category table

        $products = self::where("parent_product_id", null)
            ->whereHas('category', function ($query) use ($parentCategoryID) {
                $query->where('parent_categories_id', $parentCategoryID);
            })
            ->where("product_id", "!=", $id)
            ->whereNot('status', 0)
            ->orderBy('status')
            ->orderBy('stock', 'desc')
            ->with('category')
            ->paginate(25, ['*'], 'page1');



        return $this->_transformRatingProduct($products);
    }

    /**
     * Retrieves the options of a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return
     * 09/01/2024
     * version:1
     * **/
    public function getOptionsByProduct(int $id): ?Product
    {
        $product = self::with('options')->where('product_id', $id)->first();

        if (!$product) {
            return null;
        }

        return $product;
    }


    /**
     * Retrieve options with the specified product ID.
     *
     * @param int $productID The ID of the product
     * @return Collection
     * 21/01/2024
     * version:1
     */
    public function getOptionsWithParentID(int $productID): ?Collection
    {
        $currentProduct = $this->where('product_id', $productID)->first();

        if (!$currentProduct) {

            return null;
        }

        $query = $this->where('product_id', $productID);
        if (!$currentProduct->parent_product_id) {

            $query
                ->orWhere('parent_product_id', $productID)
                ->whereNot('status', 0);
        } else {
            $query
                ->orWhere(
                    "product_id",
                    $currentProduct->parent_product_id
                )
                ->orWhere('parent_product_id', $currentProduct->parent_product_id)
                ->whereNot('status', 0);
        }
        return $query->get();
    }

    /**
     * Retrieves the option name for a given product and option ID.
     *
     * @param int $product_id The ID of the product.
     * @param int $option_id The ID of the option.
     * @return OptionProduct|null The option name if found, or null if not found.
     * 10/01/2024
     * version:1
     */
    public function getOptionsName(int $product_id, int $option_id)
    {
        $optionName = OptionProduct::with('product')->where('product_id', $product_id)->where('option_id', $option_id)->first();

        if (!$optionName) {
            return null;
        }
        return $optionName;
    }



    /**
     * Retrieves the top selling products.
     *
     * @param int $take The number of products to retrieve. Default is 8.
     * @return Collection The collection of top selling products.
     * 18/01/2024
     * version:1
     */
    public function getTopSellingProducts(int $take = 8): LengthAwarePaginator
    {
        $topSellingProducts = self::withCount('orders')
            ->where('parent_product_id', null)
            ->whereNot('status', 0)
            ->withAvg('reviews', 'rating')
            ->whereNot('is_delete', 1)
            ->whereNot('stock', 0)
            ->orderBy('status', 'asc')
            ->orderByDesc('orders_count')
            ->paginate($take);

        return $topSellingProducts;
    }

    /**
     * Retrieves the newest products.
     *
     * @param int $take The number of products to retrieve. Default is 8.
     * @return \Illuminate\Pagination\LengthAwarePaginator The paginated list of newest products.
     */
    public function getNewestProducts(int $take = 8): LengthAwarePaginator
    {
        return self::where('status', '<>', 0)
            ->where('parent_product_id', null)
            ->where('is_delete', '<>', 1)
            ->where('stock', '>', 0)
            ->withAvg('reviews', 'rating')
            ->orderBy('status', 'asc')
            ->orderByDesc('created_at')
            ->paginate($take);
    }

    /**
     * Retrieves the top rated products.
     *
     * @param int $take The number of products to retrieve.
     * @return LengthAwarePaginator The collection of top rated products.
     */
    public function getTopRatedProducts(int $take): LengthAwarePaginator
    {


        $products = self::where('parent_product_id', null)->whereNot('status', 0)->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_count')
            ->orderByDesc('reviews_avg_rating')
            ->paginate($take);

        foreach ($products as $product) {
            $averageRating = $product->reviews->avg('rating');
            $product->setAttribute('rating', $averageRating);
        }
        return $products;
    }

    /**
     * Retrieves a collection of products with the given IDs.
     *
     * @param array $ids The array of product IDs.
     * @return Collection The collection of products.
     */
    public function getProductWithIDArray(array $ids): Collection
    {
        $products = self::whereIn('product_id', $ids)->get();
        foreach ($products as $product) {
            $avgRating = ceil(collect($product->reviews)->avg("rating"));
            $product->rating = $avgRating ?? 0;
        }
        return $products;
    }




    /**
     * Transforms the rating of each product in the given LengthAwarePaginator object.
     *
     * @param LengthAwarePaginator $products The LengthAwarePaginator object containing the products.
     * @throws None
     * @return LengthAwarePaginator The transformed LengthAwarePaginator object with updated ratings.
     * 10/01/2024
     * version:2
     * note: This function previously has private access, now it has changed to public access
     */
    public function _transformRatingProduct(LengthAwarePaginator $products)
    {
        $products->getCollection()->transform(function ($product) {
            $avgRating = ceil(collect($product->reviews)->avg("rating"));
            $product->rating = $avgRating ?? 0;
            return $product;
        });
        return $products;
    }

    public function searchProductElastic(array $searchData)
    {
        extract($searchData);
        return Product::search("product_name:\"$searchName\"", function (Client $client, Search $body) use ($searchData) {
            $body->setSize(self::PER_PAGE_CLIENT);

            $betweenDate = formatBetweenQuery(
                data_get($betweenDate, 'field'),
                data_get($betweenDate, 'from'),
                data_get($betweenDate, 'to')
            );

            if ($betweenDate) {
                $body->addQuery($betweenDate);
            }

            return $client->search([
                'index' => (new Product())->searchableAs(),
                'body' => $body->toArray()
            ])->asArray();
        })
            ->orderBy('product_id', 'asc')
            ->where('is_delete', Constants::NOT_DESTROY);
    }
}
