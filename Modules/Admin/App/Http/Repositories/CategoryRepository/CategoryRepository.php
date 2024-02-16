<?php

namespace Modules\Admin\App\Http\Repositories\CategoryRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Category::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getChildCategoryList()
    {
        return $this->model->getList(true, true);
    }

    public function getParentCategoryList()
    {
        return $this->model->getList(true, false);
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getDetail(int $id)
    {
        return $this->model->getDetail($id);
    }

    public function createNewUpdate(array $arrCategoryData, string $method = 'POST', int $id = 0)
    {
        if ($method === 'POST') {
            $this->model->create([
                'parent_categories_id' => $arrCategoryData['parent_flag'] ? $arrCategoryData['parent_categories_id'] : null,
                'category_name' => $arrCategoryData['category_name'],
                'updated_by' => auth()->guard('admin')->user()->admin_id
            ]);
            $message = 'Create new product successfully!';
        } else {
            $this->model->updateCategory($id, [
                'parent_categories_id' => $arrCategoryData['parent_flag'] ? $arrCategoryData['parent_categories_id'] : null,
                'category_name' => $arrCategoryData['category_name'],
                'updated_by' => auth()->guard('admin')->user()->admin_id
            ]);
            $message = 'Update category successfully!';
        }

        return Response([
            'title' => $message,
            'message' => $message,
            'redirect' => route('admin.categories.index')
        ]);
    }

    public function destroy(int $id)
    {
        $this->model->updateCategory($id, [
            'is_delete' => Constants::DESTROY
        ]);

        $this->model->updateDeleteProductState($id);

        return Response([
            'title' => 'Delete category successfully!',
            'message' => 'Selected Category has been deleted successfully!'
        ]);
    }
}
