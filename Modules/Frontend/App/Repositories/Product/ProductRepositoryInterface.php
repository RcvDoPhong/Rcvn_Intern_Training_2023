<?php

namespace Modules\Frontend\App\Repositories\Product;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface ProductRepositoryInterface extends RepositoryInterface
{
    const MAX_PRICE = 1000000000;

    public function getProductWithQuery(Request $request): LengthAwarePaginator;

    public function getSingleProduct(int $id): array;

    public function changeViewMode(Request $request, LengthAwarePaginator $products):string;

    public function getOptionsByProduct(int $id): array;

    public function getTopSellingProducts(int $take): LengthAwarePaginator;
    public function getNewestProducts(int $take): LengthAwarePaginator;
    public function getTopRatedProducts(int $take): LengthAwarePaginator;
    public function getRelateProduct(int $id, int $parentCategoryID): LengthAwarePaginator;

    public function getOptionByProductParentID(int $productID): ?Collection;
    public function getProductWithIDArray(array $idArray): ?Collection;
    public function getRecentViewedProduct(): ?Collection;
}
