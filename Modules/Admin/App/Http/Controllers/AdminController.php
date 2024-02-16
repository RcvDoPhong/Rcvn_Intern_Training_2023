<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\AdminRepository\AdminRepositoryInterface;
use Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepository;
use Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepositoryInterface;
use Modules\Admin\App\Http\Repositories\ReviewRepository\ReviewRepositoryInterface;
use Modules\Admin\App\Http\Repositories\RoleRepository\RoleRepositoryInterface;
use Modules\Admin\App\Http\Repositories\UserRepository\UserRepositoryInterface;
use Modules\Admin\App\Http\Requests\AdminCreateNewRequest;
use Modules\Admin\App\Http\Requests\AdminUpdatePasswordRequest;
use Modules\Admin\App\Http\Requests\AdminUpdateRequest;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected AdminRepositoryInterface $adminRepo;
    protected RoleRepositoryInterface $roleRepo;
    protected OrderRepositoryInterface $orderRepo;
    protected ReviewRepositoryInterface $reviewRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(
        AdminRepositoryInterface $adminRepo,
        RoleRepositoryInterface $roleRepo,
        OrderRepositoryInterface $orderRepo,
        ReviewRepositoryInterface $reviewRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->adminRepo = $adminRepo;
        $this->roleRepo = $roleRepo;
        $this->orderRepo = $orderRepo;
        $this->reviewRepo = $reviewRepo;
        $this->userRepo = $userRepo;
    }

    public function dashboard()
    {
        $arrFields = formatDashboardField(Constants::DASHBOARD_FIELDS);
        return view('admin::pages.dashboard.index', [
            'title' => 'Dashboard',
            'orderCount' => $arrFields['orders']->name,
            'totalMoney' => $arrFields['totalPrice']->name,
            'users' => $arrFields['users']->name,
            'reviews' => $arrFields['reviews']->name
        ]);
    }

    public function index(Request $request)
    {
        return view('admin::pages.admins.index', [
            'title' => 'User management',
            'admins' => $this->adminRepo->getPaginatedList($request->all()),
            'roleList' => $this->roleRepo->getList(),
            'genderList' => Constants::GENDERS,
            'statList' => Constants::ACTIVE_LIST,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::pages.admins.create', [
            'title' => 'Create new user',
            'genderList' => Constants::GENDERS,
            'activeList' => Constants::ACTIVE_LIST,
            'roles' => $this->roleRepo->getList()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdminCreateNewRequest $request)
    {
        return $this->adminRepo->createNewUpdate($request->all(), Auth::guard('admin')->user()->admin_id);
    }

    public function updatePassword(AdminUpdatePasswordRequest $request)
    {
        return $this->adminRepo->updatePassword($request->id, $request->all(), Auth::guard('admin')->user()->admin_id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $admin = $this->adminRepo->getDetail($request->id);

        if (is_null($admin)) {
            flashMessage('message', 'User not found', 'danger');

            return redirect()->back();
        }

        return view('admin::pages.admins.edit', [
            'title' => 'Update user',
            'admin' => $admin,
            'genderList' => Constants::GENDERS,
            'activeList' => Constants::ACTIVE_LIST,
            'roles' => $this->roleRepo->getList()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminUpdateRequest $request)
    {
        return $this->adminRepo->createNewUpdate(
            $request->all(),
            Auth::guard('admin')->user()->admin_id,
            $request->_method,
            $request->id,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->adminRepo->lockOrDelete($request->id, true);
        // return $this->adminRepo->deleteAdmin($request->id);
    }

    public function lock(Request $request)
    {
        return $this->adminRepo->lockOrDelete($request->id);
    }
}
