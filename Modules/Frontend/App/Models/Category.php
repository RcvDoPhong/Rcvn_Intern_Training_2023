<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory;
    // use Searchable;

    protected $primaryKey = 'category_id';
    protected $table = 'categories';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['category_name', 'parent_categories_id', 'is_active', 'is_delete', 'updated_by'];

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    public function toSearchableArray()
    {
        return $this->only('category_name', 'parent_categories_id', 'updated_at');
    }

    public function categoryParent()
    {
        return $this->belongsTo(self::class, 'parent_categories_id');
    }


    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'category_id');
    }

    public function activeCategories()
    {

        return self::where('is_active', 1)->where('is_delete', 0);
    }

    /**
     * Returns the parent brands.
     *
     * @throws Some_Exception_Class description of exception
     * @return Brand|null The parent brands.
     * version:2
     * 08/01/2024
     */
    public function getParentCategories(): ?Collection
    {
        return $this->activeCategories()->whereNull('parent_categories_id')->get();
    }

    /**
     * Retrieve the child categories of the current category.
     *
     * @return Collection|null
     * version:2
     * 08/01/2024
     */
    public function getChildCategories(): ?Collection
    {
        return $this->activeCategories()->whereNotNull('parent_categories_id')->get();
    }

    /**
     * Retrieves the top parent categories with pagination.
     *
     * @param int $top The number of top parent categories to retrieve
     * @return LengthAwarePaginator|null The paginated list of top parent categories
     * version:1
     * 07/02/2024
     */
    public function getTopParentCategories(int $top = 3): ?LengthAwarePaginator
    {
        return $this->activeCategories()->whereNull('parent_categories_id')->paginate($top);
    }
}
