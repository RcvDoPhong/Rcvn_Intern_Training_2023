<?php

namespace Modules\Frontend\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Frontend\App\Repositories\Order\OrderRepositoryInterface;

class OrderHistoryController extends Controller
{
    private $orderRepo;
    public function __construct(OrderRepositoryInterface $orderRepo)
    {
        $this->orderRepo = $orderRepo;
    }

            /**
     * Retrieves the order history and renders the view for the order history page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View The rendered view for the order history page.
     */
    public function index()
    {
        $ordersHistory = $this->orderRepo->getOrderHistory();
        return view('frontend::pages.order.order-history.index', [
            'ordersHistory' => $ordersHistory
        ]);
    }

       /**
    * Cancels an order.
    *
    * @param Request $request The request object containing the order details.
    * @throws Some_Exception_Class A description of the exception that can be thrown.
    * @return array An array with the message "Hủy đơn".
    */
   public function cancelOrder(Request $request){

        $this->orderRepo->cancelOrder($request);

        return ["message" => "Hủy đơn"];
   }
}
