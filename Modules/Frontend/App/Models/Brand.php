<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Frontend\Database\factories\BrandFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Brand extends Model
{
    use HasFactory;
    // use Searchable;

    protected $table = 'brands';
    protected $primaryKey = 'brand_id';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'brand_name',
        'brand_logo',
        'founded',
        'is_active',
        'is_delete',
        'updated_by'

    ];

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    public function toSearchableArray()
    {
        return $this->only('brand_name', 'founded', 'updated_at');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'brand_id');
    }

    public function activeBrand()
    {
        return $this->where("is_active", 1)
            ->where('is_delete', 0);
    }

    /**
     * Retrieves a paginated list of brands.
     *
     * @param int|null $paginate The number of items to display per page. Defaults to 5.
     * @return LengthAwarePaginator The paginated list of brands.
     * version:1
     * 08/01/2024
     */
    public  function getBrands(?int $paginate = 5): LengthAwarePaginator
    {
        return $this->activeBrand()->paginate($paginate);
    }


    /**
     * Retrieves the top brands with pagination.
     *
     * @param int $page The page number to retrieve.
     * @throws \Exception If an error occurs while retrieving the top brands.
     * @return \Illuminate\Pagination\LengthAwarePaginator The paginated list of top brands.
     */
    public function getTopBrand(int $page = 4): LengthAwarePaginator
    {
        return $this->activeBrand()->withCount('products')
            ->orderBy('products_count', 'desc')
            ->paginate($page);
    }

    /**
     * Retrieves products by brand ID and paginates the results.
     *
     * @param int $brandId The ID of the brand to retrieve products for.
     * @param int $page The page number for pagination (default: 15).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator The paginated products.
     */
    public function getProductsByBrandId(int $brandId, int $page = 15): LengthAwarePaginator
    {
        return Product::where('brand_id', $brandId)
            ->where('is_delete', 0)
            ->withAvg('reviews', 'rating')
            ->with('category')->paginate($page);
    }
}
