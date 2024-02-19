<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Scout\Searchable;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\database\factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;
    // use Searchable;

    private string $parentIdField = 'parent_categories_id';

    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'parent_categories_id',
        'category_name',
        'is_active',
        'is_delete',
        'updated_by'
    ];

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    protected static function newFactory(): CategoryFactory
    {
        return CategoryFactory::new();
    }

    public function isExistByName(string $name, bool $excluded = false, int $id = 0): bool
    {
        $query = self::where('category_name', $name);

        if ($excluded) {
            $query = $query->where($this->primaryKey, '<>', $id);
        }

        return $query->exists();
    }

    public function isExistById(int $id): bool
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, $this->parentIdField, $this->primaryKey);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class, $this->parentIdField);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'admin_id');
    }

    public function isParent(int $id): bool
    {
        return self::where($this->primaryKey, $id)
                    ->where($this->parentIdField, '=', null)
                    ->exists();
    }

    public function getList(bool $filter = false, bool $parentFlag = false): Collection
    {
        $query = self::where('is_delete', '<>', Constants::DESTROY);

        if ($filter) {
            $query = $query->where($this->parentIdField, $this->handleParentFlagQuery($parentFlag), null);
        }

        return $query->get();
    }

    public function handleParentFlagQuery(bool $parentFlag)
    {
        return $parentFlag ? '<>' : '=';
    }

    public function getPaginatedList(array $arrSearchData): LengthAwarePaginator
    {
        $query = self::where('is_delete', '<>', Constants::DESTROY);

        if (!empty($arrSearchData)) {
            $conditions = formatQuery(array_diff_key($arrSearchData, [
                'parent_flag' => 0
            ]));

            $query = $query->where($conditions);

            if (!is_null($parentFlag = data_get($arrSearchData, 'parent_flag'))) {
                $query = $query->where('parent_categories_id', $this->handleParentFlagQuery($parentFlag), null);
            }
        }

        return $query->orderBy('updated_at', 'DESC')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function getDetail(int $id)
    {
        if ($this->isExistById($id)) {
            $category = self::where($this->primaryKey, $id)->first();

            if ($category->is_delete !== Constants::DESTROY) {
                return $category;
            }
        }

        return null;
    }

    public function updateCategory(int $id, array $arrCategoryData): void
    {
        $category = $this->getDetail($id);
        if ($category) {
            $category->update($arrCategoryData);
        }
        // self::where($this->primaryKey, $id)->update($arrCategoryData);
    }

    public function updateDeleteProductState(int $categoryId)
    {
        Product::where('category_id', $categoryId)->update([
            'category_id' => null
        ]);
    }
}
