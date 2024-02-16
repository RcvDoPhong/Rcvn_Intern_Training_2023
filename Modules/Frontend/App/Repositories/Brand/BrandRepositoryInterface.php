<?php
namespace Modules\Frontend\App\Repositories\Brand;

use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface BrandRepositoryInterface extends RepositoryInterface
{

    public function getBrands(?int $paginate = 5): LengthAwarePaginator;

    public function getTopBrandWithProduct(int $page = 4): array;
}
