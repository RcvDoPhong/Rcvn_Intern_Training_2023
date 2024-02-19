<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;
use Modules\Frontend\App\Repositories\Brand\BrandRepositoryInterface;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;
use Modules\Frontend\App\Repositories\Category\CategoryRepositoryInterface;

/**
 * CategoryController using for category page and its functionality
 * 05/01/2024
 * version:1
 */
class CategoryController extends Controller
{
    private $userRepo;
    private $productRepo;

    private $categoryRepo;

    private $brandRepo;
    public function __construct(UserRepositoryInterface $userRepo, ProductRepositoryInterface $productRepo, CategoryRepositoryInterface $categoryRepo, BrandRepositoryInterface $brandRepo)
    {
        $this->userRepo = $userRepo;
        $this->productRepo = $productRepo;

        $this->categoryRepo = $categoryRepo;

        $this->brandRepo = $brandRepo;
    }

    /**
     * Returns the view for the index page of the category module in the frontend.
     *
     * @throws Some_Exception_Class description of exception
     * @return View
     * 05/01/2024
     * version:1
     */
    public function index(Request $request): View
    {
        $searchName = $request->input('searchName');
        $products = $this
            ->productRepo
            ->getProductWithQuery(
                $request
            );
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


    public function queryProduct(Request $request)
    {
        $validate = Validator::make([
            "minPrice" => $request->minPrice[0]
                ?? null,
            "maxPrice" => $request->maxPrice[0] ?? null
        ], [
            'minPrice' => 'nullable|numeric|min:0|max:1000000000',
            'maxPrice' => 'nullable|numeric|gt:minPrice|max:1000000000',
        ]);
        if ($validate->fails()) {
            return new Response([
                'status' => 400,
                'errors' => $validate->errors(),
            ]);
        }

        $products = $this
            ->productRepo
            ->getProductWithQuery(
                $request
            );

        $links = null;
        if (isset($products['data']->links)) {
            $links = $products['data']->links;
        } else {
            $links = $products['data']->links();
        }

        return [
            'searchType' => $request->searchType,
            "view" => $this->productRepo->changeViewMode($request, $products['data']),
            'executionTime' => $products['executionTime'],
            "pagination" => $links->toHtml(),
        ];
    }
}
