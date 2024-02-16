<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Modules\Frontend\App\Repositories\Order\OrderRepositoryInterface;
use Modules\Frontend\App\Repositories\Product\ProductRepositoryInterface;
use Modules\Frontend\App\Repositories\Review\ReviewRepositoryInterface;

class OrderHistoryDetailController extends Controller
{

    private $orderRepo;
    private $productRepo;
    private $reviewRepo;
    public function __construct(OrderRepositoryInterface $orderRepo, ProductRepositoryInterface $productRepo, ReviewRepositoryInterface $reviewRepo)
    {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->reviewRepo = $reviewRepo;
    }

    /**
     * Retrieves the order history detail for a given ID.
     *
     * @param Request $request The HTTP request object.
     * @param int $id The ID of the order history.
     * @throws Some_Exception_Class Description of the exception that may be thrown.
     * @return View Returns the view for the order history detail.
     * 18/01/2024
     * version:1
     */
    public function index(Request $request, int $id): View
    {
        $orderHistory = $this->orderRepo->getOrderHistoryById($id);
        return view(
            'frontend::pages.order.order-history-detail.index',
            ["orderHistory" => $orderHistory]
        );
    }

    /**
     * A description of the entire PHP function.
     *
     * @param Request $request The request object.
     * @throws \Some_Exception_Class Description of the exception.
     * @return View The view object.
     * 18/01/2024
     * version:1
     */
    public function reviewPage(Request $request, int $orderHistoryID, int $productID): View
    {

        $product = $this->productRepo->getSingleProduct($productID);
        $orderHistory = $this->orderRepo->getOrderHistoryById($orderHistoryID);
        $isExistReview = $this->reviewRepo->isExistReviewProduct($productID);

        return view(
            'frontend::pages.order.order-product-review.index',
            [
                "product" => $product["product"],
                "orderHistory" => $orderHistory,
                "isExistReview" => $isExistReview
            ]
        );
    }

    public function addReview(Request $request)
    {
        // Validate request
        $request->validate([
            'review-images' => 'nullable|array|max:4',
            'review-images.*' => 'file|image|mimes:jpeg,png,jpg,gif|max:4096', // max 4MB
            'title' => 'required|max:127|min:3',
            'comment' => 'required|max:300',
        ]);

        $orderHistoryID = (int) $request->input('order_history_id');
        $review = $this->reviewRepo->addReview($request, $request->input('product_id'));
        $this->reviewRepo->uploadReviewImage($request, $review['review_id']);

        return (int) $orderHistoryID;
    }
}
