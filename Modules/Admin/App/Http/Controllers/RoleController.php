<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Repositories\RoleRepository\RoleRepositoryInterface;
use Modules\Admin\App\Http\Requests\RoleFormRequest;

class RoleController extends Controller
{
    protected RoleRepositoryInterface $roleRepo;

    public function __construct(RoleRepositoryInterface $roleRepo) {
        $this->roleRepo = $roleRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.roles.index', [
            'title' => 'Role Management',
            'roles' => $this->roleRepo->getPaginatedList($request->all())
        ]);
    }

    public function permissions(Request $request)
    {
        return $this->roleRepo->getPermissions($request->id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::pages.roles.create', [
            'title' => 'Create new role',
            'permissions' => $this->roleRepo->getPermissionList()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleFormRequest $request)
    {
        return $this->roleRepo->createNewUpdate($request->all());
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        return $this->roleRepo->getDetail($request->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('admin::edit');
    }

    public function update(RoleFormRequest $request)
    {
        return $this->roleRepo->createNewUpdate($request->except('_method'), $request->_method, [], $request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePermission(Request $request)
    {
        return $this->roleRepo->updateRolePermissions($request->id, $request->except('_method'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->roleRepo->destroy($request->id);
    }
}
