<?php
namespace Modules\Frontend\App\Repositories\Category;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface CategoryRepositoryInterface extends RepositoryInterface
{

    public function getCategories(): array;
}
