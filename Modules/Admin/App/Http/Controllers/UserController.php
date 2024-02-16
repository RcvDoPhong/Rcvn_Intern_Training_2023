<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\CityRepository\CityRepositoryInterface;
use Modules\Admin\App\Http\Repositories\DistrictRepository\DistrictRepositoryInterface;
use Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepositoryInterface;
use Modules\Admin\App\Http\Repositories\UserRepository\UserRepositoryInterface;
use Modules\Admin\App\Http\Repositories\WardRepository\WardRepositoryInterface;
use Modules\Admin\App\Http\Requests\UserUpdatePasswordRequest;
use Modules\Admin\App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{

    protected UserRepositoryInterface $userRepo;
    protected CityRepositoryInterface $cityRepo;
    protected DistrictRepositoryInterface $districtRepo;
    protected WardRepositoryInterface $wardRepo;
    protected OrderRepositoryInterface $orderRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        CityRepositoryInterface $cityRepo,
        DistrictRepositoryInterface $districtRepo,
        WardRepositoryInterface $wardRepo,
        OrderRepositoryInterface $orderRepo
    ) {
        $this->userRepo = $userRepo;
        $this->cityRepo = $cityRepo;
        $this->districtRepo = $districtRepo;
        $this->wardRepo = $wardRepo;
        $this->orderRepo = $orderRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.users.index', [
            'title' => 'Customer management',
            'users' => $this->userRepo->getPaginatedList($request->all()),
            'genderList' => Constants::GENDERS,
            'statList' => Constants::ACTIVE_LIST
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        return $this->userRepo->getDetail($request->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $user = $this->userRepo->getDetail($request->id);
        return view('admin::pages.users.user', [
            'title' => "Customer's info",
            'user' => $this->userRepo->getDetail($request->id),
            'cities' => $this->cityRepo->getList(),
            'districtsDelivery' => $this->districtRepo->getDistricts($user->delivery_city_id),
            'wardsDelivery' => $this->wardRepo->getWards($user->delivery_ward_id),
            'districtsBilling' => $this->districtRepo->getDistricts($user->billing_city_id),
            'wardsBilling' => $this->wardRepo->getWards($user->billing_district_id),
            'genderList' => Constants::GENDERS
        ]);
    }

    public function orders(Request $request)
    {
        $orders = $this->userRepo->getPaginatedOrdersList($request->all(), $request->id);
        return view('admin::pages.users.orders', [
            'title' => "Customer's orders",
            'orders' => $orders,
            'statuses' => $this->orderRepo->getOrderStatues(),
            'statuses' => $this->orderRepo->getOrderStatues(),
            'shippings' => $this->orderRepo->getShippingsList(),
            'payments' => Constants::PAYMENT_LIST,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request)
    {
        return $this->userRepo->updateUser($request->except('_method'), $request->id);
    }

    public function updatePassword(UserUpdatePasswordRequest $request)
    {
        return $this->userRepo->updatePassword($request->id, $request->except('_method'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->userRepo->lockOrDelete($request->id, true);
    }

    public function lock(Request $request)
    {
        return $this->userRepo->lockOrDelete($request->id);
    }
}
