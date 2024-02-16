<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Frontend\App\Repositories\Brand\BrandRepositoryInterface;
use Modules\Frontend\App\Repositories\Category\CategoryRepositoryInterface;
use Modules\Frontend\App\Repositories\Home\HomeRepositoryInterface;
use Modules\Frontend\App\Repositories\Order\OrderRepositoryInterface;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;

/**
 * HomeController using for home page and its functionality
 * 04/01/2024
 * version:1
 */
class HomeController extends Controller
{


    private $productRepo;
    private $brandRepo;

    private $orderRepo;

    private $categoryRepo;

    private HomeRepositoryInterface $homeRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo,
        OrderRepositoryInterface $orderRepo,
        CategoryRepositoryInterface $categoryRepo,
        HomeRepositoryInterface $homeRepo
    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->orderRepo = $orderRepo;
        $this->categoryRepo = $categoryRepo;
        $this->homeRepo = $homeRepo;
    }


    /**
     * Display a home page.
     * 05/01/2024
     * version:1
     */
    public function index(Request $request): View
    {

        $products = $this->productRepo->getProductWithQuery(
            $request
        );

        $topSellingProduct = $this->productRepo->getTopSellingProducts(8);
        $newestProducts = $this->productRepo->getNewestProducts(8);
        $topRatedProducts = $this->productRepo->getTopRatedProducts(4);
        $brands = $this->brandRepo->getBrands(20);
        $topBrandWithProduct = $this->brandRepo->getTopBrandWithProduct(4);

        $categories = $this->categoryRepo->getCategories();

        return view(
            'frontend::pages.home.index',
            [
                'topSellingProducts' => $topSellingProduct,
                'newestProducts' => $newestProducts,
                "topRatedProducts" => $topRatedProducts,
                "featuredProducts" => $products,
                "topBrandWithProduct" => $topBrandWithProduct,
                "brands" => $brands,
                "categories" => $categories
            ]
        );
    }

    public function searchList(Request $request)
    {
        return $this->homeRepo->searchList($request->searchName);
    }

    public function searchElastic(Request $request, bool $sqlSearchFlag = false)
    {
        $searchName = $request->input('searchName');
        $products = $this->homeRepo->search($searchName, $sqlSearchFlag);
        $categories = $this->categoryRepo->getCategories();
        $checkCategory = $request->input('category_id');

        $brands = $this->brandRepo->getBrands(50);
        return view(
            'frontend::pages.category.index',
            [
                'products' => $products['data'],
                'executionTime' => $products['executionTime'],
                'childCategories' => $categories['child'],
                'parentCategories' => $categories['parent'],
                'brands' => $brands,
                "checkCategory" => $checkCategory,
                'searchName' => $searchName
            ]
        );
    }

    public function searchSQL(Request $request)
    {
        return $this->searchElastic($request, true);
    }
}
