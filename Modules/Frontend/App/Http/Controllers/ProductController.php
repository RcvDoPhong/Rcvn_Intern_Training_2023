<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;

/**
 * ProductController using for product detail  its functionality
 * 09/01/2024
 * version:1
 */
class ProductController extends Controller
{

    private $productRepo;
    private $cartRepo;
    public function __construct(ProductRepositoryInterface $productRepo, CartRepositoryInterface $cartRepo)
    {
        $this->cartRepo = $cartRepo;
        $this->productRepo = $productRepo;
    }

    /**
     * Retrieves the necessary information for the product detail page.
     *
     * @param int $id The ID of the product
     * @return View The rendered view for the product detail page
     */
    public function index(Request $request, $id): View|array
    {

        $product = $this->_getProductInformation((int) $id);
        if ($request->ajax()) {

            return [
                "view" => view('frontend::pages.product-detail.section.review-section', [

                    'reviews' => $product['reviews']
                ])->render(),
                'pagination' => $product['reviews']->links()->toHtml(),
            ];
        }

        $this->cartRepo->addRecentlyViewedProduct($id);

        return view('frontend::pages.product-detail.index', [
            "product" => $product["product"],
            'relatedProducts' => $product['relatedProducts'],
            "options" => $product["options"],
            'reviews' => $product['reviews'],
            'images' => $product['images'],
        ]);
    }


    /**
     * Retrieves the product information for a given ID.
     *
     * @param int $id The ID of the product.
     * @return array The product information including related products, options, reviews, and images.
     */
    private function _getProductInformation(int $id): array
    {

        $getProductAndReviews = $this->productRepo->getSingleProduct($id);
        $product = $getProductAndReviews['product'];
        $reviews = $getProductAndReviews['reviews'];

        if (empty($product)) {
            return [
                "product" => [],
                'relatedProducts' => [],
                "options" => [],
                'reviews' => [],
                "images" => [],
            ];
        }

        $parentCategoriesID = $product['category']['parent_categories_id'] ?? "Nothing";

        $relatedProducts = $this->productRepo->getRelateProduct($product['product_id'], $parentCategoriesID);
        $options = $this->productRepo->getOptionByProductParentID($id);

        $images = $product['productImage'];
        return [
            "product" => $product,
            'relatedProducts' => $relatedProducts,
            "options" => $options,
            'reviews' => $reviews,
            "images" => $images
        ];
    }
}
