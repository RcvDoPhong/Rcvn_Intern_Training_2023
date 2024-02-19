<?php

namespace Modules\Frontend\App\Repositories\Product;



use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Frontend\App\Models\Review;
use Modules\Frontend\App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\Review\ReviewRepositoryInterface;

/**
 * class UserRepository for registering and authenticating users.
 *
 * 4/1/2023
 * version:1
 */
class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    const MAX_PRICE = 1000000000;

    private $cartRepo;

    public function __construct(
        CartRepositoryInterface $cartRepo
    ) {
        parent::__construct();

        $this->cartRepo = $cartRepo;
    }

    public function getModel()
    {
        return Product::class;
    }

    /**
     * Retrieves a paginated list of products based on the provided query parameters.
     *
     * @param Request $request The HTTP request object containing the query parameters.
     * @throws Some_Exception_Class Description of exception (if applicable).
     * @return LengthAwarePaginator The paginated list of products.
     */
    public function getProductWithQuery(
        Request $request
    ): array { // old: LengthAwarePaginator
        $defaultOptions = [
            "paginate" => 9,
            'categoryIdArr' => $request->category,
            'brandIdArr' => $request->brand,
            'minPrice' => $request->minPrice[0] ?? 0,
            'maxPrice' => $request->maxPrice[0] ?? 1000000000,
            'sortName' => $request->sortName ?? "date",
            'searchName' => $request->searchName ?? '',
            'ratingArr' => $request->rating,
        ];

        if ($request->searchType === 'sql') {
            return $this->model->getProductWithQuerySQL(
                $defaultOptions
            );
        }

        return $this->model->getProductWithQueryElastic($defaultOptions);
    }

    public function changeViewMode(Request $request, LengthAwarePaginator|Collection $products, int $queryTime = 0): string
    {

        $routeViewName = $request->currentView === "grid"
            ? 'frontend::pages.category.include.product-list.product-list-grid'
            : 'frontend::pages.category.include.product-list.product-list-row';
        return view("$routeViewName", ['products' => $products])->render();
    }


    /**
     * Retrieves a sorted list of products.
     *
     * @param int|null $paginate The number of items per page (nullable).
     * @param string $sortName The name of the sort criteria.
     * @return LengthAwarePaginator The sorted list of products.
     */

    public function getProductWithSort(?int $paginate, string $sortName): LengthAwarePaginator
    {

        return $this->model::getProductWithSort($paginate, $sortName);
    }

    /**
     * Retrieves a single product by its ID.
     *
     * @param int $id The ID of the product to retrieve.
     * @param int $perPage The number of products to display per page (default: 4).
     * @return array The details of the single product.
     */
    public function getSingleProduct(int $id): array
    {
        return $this->model->getSingleProduct($id);
    }

    /**
     * Retrieves a collection of related products based on the given ID and parent category ID.
     *
     * @param int $id The ID of the product.
     * @param int $parentCategoryID The ID of the parent category.
     * @throws \Some_Exception_Class A description of the exception that may be thrown.
     * @return LengthAwarePaginator The collection of related products.
     */
    public function getRelateProduct(int $id, int $parentCategoryID): LengthAwarePaginator
    {
        return $this->model->getRelateProduct($id, $parentCategoryID);
    }

    /**
     * Retrieves options for a product by its ID.
     *
     * @param int $id The ID of the product.
     * @return array The options for the product.
     */
    public function getOptionsByProduct(int $id): array
    {
        $product = $this->model->getOptionsByProduct($id);
        if ($product) {
            $collectOption = collect($product['options']);
            $newCollectOption = $collectOption->map(function ($option) {
                $eachOptionProduct = $this->model->getOptionsName($option->product_id, $option->option_id)['product'];


                return [
                    'product_id' => $option->product_id,
                    "option_id" => $option->option_id,
                    "option_name" => $eachOptionProduct->option_name,
                ];
            });
            return $newCollectOption->toArray();
        }
        return [];
    }

    public function getOptionByProductParentID(int $productID): ?Collection
    {
        return $this->model->getOptionsWithParentID($productID);
    }


    /**
     * Retrieves the top selling products.
     *
     * @param int $take The number of products to retrieve.
     * @throws Some_Exception_Class If there is an error retrieving the products.
     * @return LengthAwarePaginator The collection of top selling products.
     * 18/01/2024
     * version:1
     */
    public function getTopSellingProducts(int $take): LengthAwarePaginator
    {
        return $this->model->getTopSellingProducts($take);
    }

    /**
     * Retrieves the newest products from the database.
     *
     * @param int $take The number of products to retrieve.
     * @return LengthAwarePaginator A paginator object containing the newest products.
     * 18/01/2024
     * version:1
     */
    public function getNewestProducts(int $take): LengthAwarePaginator
    {
        return $this->model->getNewestProducts($take);
    }

    /**
     * Retrieves the top rated products.
     *
     * @param int $take The number of products to retrieve.
     * @throws \Some_Exception_Class If an error occurs while retrieving the top rated products.
     * @return \LengthAwarePaginator The top rated products.
     * 18/01/2024
     * version:1
     */
    public function getTopRatedProducts(int $take): LengthAwarePaginator
    {
        return $this->model->getTopRatedProducts($take);
    }

    /**
     * Retrieves a collection of products based on an array of IDs.
     *
     * @param array $idArray An array of product IDs.
     * @return Collection A collection of products.
     * 18/01/2024
     * version:1
     */
    public function getProductWithIDArray(array $idArray): ?Collection
    {
        $getProductIDFromArray = array_column($idArray, "id");
        if (empty($getProductIDFromArray)) {
            return null;
        }
        return $this->model->getProductWithIDArray($getProductIDFromArray);
    }

    public function getRecentViewedProduct(): ?Collection
    {
        $productIDArr = $this->cartRepo->getRecentlyViewedProductsSession();
        return $this->getProductWithIDArray($productIDArr);
    }
}
