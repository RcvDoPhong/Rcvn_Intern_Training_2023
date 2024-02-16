<?php

namespace Modules\Frontend\App\Repositories\Brand;


use Modules\Frontend\App\Models\Brand;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Brand\BrandRepositoryInterface;

/**
 * class Brand Category class for retrive brands.
 *
 * 08/01/2024
 * version:1
 */
class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{


    public function getModel()
    {
        return Brand::class;
    }


    /**
     * Retrieves the brands from the database.
     *
     * @param int|null $paginate The number of items per page for pagination. Default is 5.
     * @return LengthAwarePaginator The paginated list of brands.
     * version:1
     * 08/01/2024
     */
    public function getBrands(?int $paginate = 5): LengthAwarePaginator
    {

        return $this->model->getBrands($paginate);
    }

    /**
     * Retrieves the top brand along with its associated products.
     *
     * @param int $page The page number for pagination (default: 4)
     * @return array An array containing the top brand and its associated products
     */
    public function getTopBrandWithProduct(int $page = 4): array
    {
        $topBrand = $this->model->getTopBrand($page);
        $brandArr = [];

        foreach ($topBrand as $brand) {
            $products = $this->model->getProductsByBrandId($brand['brand_id']);
            $brandArr[] = [
                'brand' => $brand,
                'products' => $products
            ];
        }

        return $brandArr;
    }
}
