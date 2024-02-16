<?php

namespace Modules\Frontend\App\Repositories\Order;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Frontend\App\Models\Order;
use Illuminate\Support\Facades\Session;
use Modules\Frontend\App\Models\OrderHistory;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\Coupon\CouponRepositoryInterface;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepository;

/**
 * class OrderRepository for payment and order history.
 *
 * 16/1/2024
 * version:1
 */
class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{

    private $userRepo;
    private $shippingRepo;

    private $cartRepo;

    private $couponRepo;

    public function __construct(
        ShippingRepositoryInterface $shippingRepo,
        CartRepositoryInterface $cartRepo,
        UserRepository $districtRepo,
        CouponRepositoryInterface $couponRepo
    ) {
        parent::__construct();
        $this->cartRepo = $cartRepo;
        $this->shippingRepo = $shippingRepo;
        $this->userRepo = $districtRepo;
        $this->couponRepo = $couponRepo;
    }

    public function getModel()
    {

        return Order::class;
    }




    /**
     * Adds an order and its details to the system.
     *
     * @param Request $request The HTTP request object.
     * @param array $carts An array of cart items.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return Order|array The order or failed array of added orders and details.
     * 17/01/2024
     * version:1
     */
    public function addOrderAndDetail(Request $request, array $carts = []): Order|array
    {

        $user = Auth::user();
        $isSameBillingAddress = $request->input('is_billing_address');
        $orderData = [
            "user_id" => $user->user_id,
            "shipping_method_id" => (int) $request->input("shipping_method_id"),
            "payment_method" => (int) $request->input("payment_method"),
            "total_price" => $request->input("total_price"),
            "subtotal_price" => $request->input("subtotal_price"),
            "coupon_price" => $request->input("coupon_price"),
            "shipping_price" => $request->input("shipping_price"),
            "coupon_code" => $request->input("coupon_code", ""),
            "city_id" => $user->delivery_city_id ?? 1,
            "district_id" => $user->delivery_district_id ?? 1,
            "ward_id" => $user->delivery_district_id ?? 1,
            "order_uid" => $this->_generateOrderUID(),
            "delivery_address" => $request->input("delivery_address"),
            "telephone_number" => $request->input("telephone_number"),
            "zip_code" => "",
            "billing_address" => $isSameBillingAddress === null
                ? $request->input("billing_address")
                : $request->input("delivery_address"),
        ];
        $orderDetailData = array_map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'quantity' => $item['product_quantity'],
                'price' => $item['display_price'],
            ];
        }, $carts);

        return $this->model->addOrderAndDetail($orderData, $orderDetailData);
    }

    public function isExistOrderUUID(string $orderUUID): bool
    {
        return $this->model->isExistOrderUUID($orderUUID);
    }

    /**
     * Check if an order UUID exists.
     *
     * @param string $orderUUID The order UUID to check.
     * @return bool Returns true if the order UUID exists, false otherwise.
     * 17/01/2024
     * version:1
     */
    public function getOrderHistory(): LengthAwarePaginator
    {
        return $this->model->getOrdersWithDetailsAndHistory(Auth::user()->user_id);
    }
    /**
     * Retrieves the order history for a user.
     *
     * @throws Some_Exception_Class if the order history cannot be retrieved.
     * @return OrderHistory|null The order history for the user, or null if there is no order history.
     *   18/01/2024
     * version:1
     */
    public function getOrderHistoryById(int $orderHistoryDetailID): ?OrderHistory
    {
        return $this->model->getOrderHistoryById(Auth::user()->user_id, $orderHistoryDetailID);
    }

    public function getPaymentInformationDetail(Request $request): array
    {
        $user = $this->userRepo->getUser(Auth::user()->user_id);
        $getMethodIDFromSession = Session::get('methodPaymentID', 1);
        $currentChooseMethod = $request->input("shippingMethodID", $getMethodIDFromSession);
        if ($request->input("currentMethodCart")) {

            $currentChooseMethod = $request->input("currentMethodCart");
        }
        Session::put('methodPaymentID', $currentChooseMethod);
        if (isset($user['delivery_city_id'])) {
            $shippingMethod = $this->shippingRepo->getMethodByCity($user['delivery_city_id']);
        } else {
            $shippingMethod = $this->shippingRepo->getAllMethod();
        }



        $currentMethod = $this->shippingRepo->getMethodByID((int) $currentChooseMethod);


        $carts = $this->cartRepo->getCart();

        $sumPrice = $this->cartRepo->sumPriceCart($carts);

        return [
            "user" => $user,
            "methods" => $shippingMethod,
            'currentMethod' => $currentMethod,
            "getCart" => ["carts" => $carts, "sumPrice" => $sumPrice],
        ];
    }


    /**
     * Cancels an order.
     *
     * @param Request $request The request object.
     * @throws Some_Exception_Class Description of the exception.
     * @return void
     * 17/01/2024
     * version:1
     */
    public function cancelOrder(Request $request): void
    {


        $orderHistoryID = $request->input("orderHistoryID");
        $this->model->cancelOrder($orderHistoryID);
    }



    /**
     * Generates a unique order UID.
     *
     * @return string The generated order UID.
     * 17/01/2024
     * version:1
     */
    public function _generateOrderUID(): string
    {
        return 'O' . uniqid(date('YmdHis'), true);
    }
}
