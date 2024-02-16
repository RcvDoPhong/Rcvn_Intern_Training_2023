<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepositoryInterface;
use Modules\Admin\App\Http\Requests\OrderUpdateStatusRequest;

class OrderController extends Controller
{
    protected OrderRepositoryInterface $orderRepo;

    public function __construct(OrderRepositoryInterface $orderRepo) {
        $this->orderRepo = $orderRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.orders.index',[
            'title' => 'Order management',
            'orders' => $this->orderRepo->getPaginatedList($request->all()),
            'statuses' => $this->orderRepo->getOrderStatues(),
            'shippings' => $this->orderRepo->getShippingsList(),
            'payments' => Constants::PAYMENT_LIST,
            'cities' => $this->orderRepo->getCitiesList(),
            'districts' => $this->orderRepo->getDistrictsList(),
            'wards' => $this->orderRepo->getWardsList()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::create');
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        return $this->orderRepo->getDetail($request->id);
    }

    public function updateStatus(OrderUpdateStatusRequest $request)
    {
        return $this->orderRepo->updateOrderStatus($request->except('_method'));
    }
}
