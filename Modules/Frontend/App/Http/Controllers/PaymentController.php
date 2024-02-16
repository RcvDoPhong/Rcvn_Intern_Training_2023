<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\Order\OrderRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;
use Modules\Frontend\App\Repositories\Coupon\CouponRepositoryInterface;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepositoryInterface;

class PaymentController extends Controller
{
    private $userRepo;
    private $shippingRepo;

    private $cartRepo;

    private $couponRepo;

    private $orderRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        ShippingRepositoryInterface $shippingRepo,
        CartRepositoryInterface $cartRepo,
        CouponRepositoryInterface $couponRepo,
        OrderRepositoryInterface $orderRepo
    ) {

        $this->userRepo = $userRepo;
        $this->shippingRepo = $shippingRepo;
        $this->cartRepo = $cartRepo;

        $this->couponRepo = $couponRepo;
        $this->orderRepo = $orderRepo;
    }


    /**
     * Retrieves the index view for the payment page.
     *
     * @return \Illuminate\View\View
     * 15/01/2024
     * version:1
     */
    public function index(Request $request): View|Response
    {

        $paymentInformation = $this->orderRepo->getPaymentInformationDetail($request);


        if ($request->ajax()) {
            return new Response($paymentInformation);
        }


        return
            view('frontend::pages.payment.index', $paymentInformation);
    }

    /**
     * Apply a coupon to the request.
     *
     * @param Request $request The request object.
     * @return Response The response object.
     */
    public function applyCoupon(Request $request)
    {
        $inputCode = $request->input('code', '');


        $coupon = $this->couponRepo->getCouponByCode($inputCode);
        $carts = $this->cartRepo->getCart();

        $sumPrice = $this->cartRepo->sumPriceCart($carts);
        $getMethodIDFromSession = Session::get('methodPaymentID', 1);

        $currentMethod = $this->shippingRepo->getMethodByID((int) $getMethodIDFromSession);


        return new Response([
            'coupon' => $coupon,
            'getCart' => ["carts" => $carts, "sumPrice" => $sumPrice],
            "currentMethod" => $currentMethod

        ]);
    }

    /**
     * Adds a payment.
     *
     * @param Request $request The request object.
     * @throws Some_Exception_Class Description of exception.
     * @return Response|string Returns a Response object if there are messages in the result, otherwise returns a string containing the route.
     */
    public function addPayment(Request $request)
    {
        $carts = $this->cartRepo->getCart();
        $result = $this->orderRepo->addOrderAndDetail($request, $carts);
        if (isset($result["messages"])) {
            return new Response($result);
        } else {
            $this->cartRepo->clearCart();
            return route(
                'frontend.payment.confirm-page',
                [
                    "orderUID" => $result->order_uid ?? "",
                    "isSuccess" => true
                ]
            );
        }
    }

    /**
     * Generates the function comment for the confirmPage function.
     *
     * @param Request $request The request object.
     * @throws Exception The exception class.
     * @return View The view object.
     */
    public function confirmPage(Request $request): View
    {
        $orderUID = $request->input("orderUID", "");
        if ($this->orderRepo->isExistOrderUUID($orderUID ?? "")) {
            return view(
                "frontend::pages.payment.payment-confirm.index",
                ["orderUID" => $orderUID, "isSuccess" => true]
            );
        }
        return view(
            "frontend::pages.payment.payment-confirm.index",
            ["orderUID" => "", "isSuccess" => false]
        );
    }

    /**
     * Change the billing address.
     *
     * @param Request $request
     */
    public function changeBillingAddress(Request $request)
    {
        return $this->userRepo->isChangeBillingAddress($request);
    }
}
