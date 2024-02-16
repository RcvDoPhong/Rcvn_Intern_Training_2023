<?php
namespace Modules\Frontend\App\Repositories\Category;


use Modules\Frontend\App\Models\Category;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Category\CategoryRepositoryInterface;

/**
 * class CategoryRepository class for retrive category.
 *
 * 08/01/2024
 * version:1
 */
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    /**
     * Retrieves the model class for the function.
     *
     * @return string The fully qualified class name of the model.
     * version:1
     * 08/01/2024
     */
    public function getModel()
    {
        return Category::class;
    }


    /**
     * Retrieves the categories.
     *
     * @return array|null The categories, with 'parent' and 'child' keys.
     * version:1
     * 08/01/2024
     */
    public function getCategories(): array
    {

        return ['parent' => $this->model->getTopParentCategories(3), 'child' => $this->model->getChildCategories()];
    }


}
