<?php

namespace Modules\Admin\App\Http\Repositories\CategoryRepository;

use App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getChildCategoryList();

    public function getParentCategoryList();

    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function createNewUpdate(array $arrCategoryData, string $method = 'POST', int $id = 0);

    public function destroy(int $id);
}
