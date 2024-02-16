<?php

namespace Modules\Admin\App\Http\Repositories\RoleRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Resources\RolePermissionResource;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Role::class;
    }

    public function getDetail(int $id)
    {
        $role = $this->model->getDetail($id);

        if (request()->ajax()) {
            if ($role) {
                return Response([
                    'data' => $role
                ]);
            }

            return Response([
                'error' => [
                    'message' => 'Role not found'
                ]
            ], 404);
        }

        return !is_null($role) ? $role : null;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getPermissionList()
    {
        return $this->model->getPermissionList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getPermissions(int $roleId)
    {
        $role = $this->model->getDetail($roleId);

        if (request()->ajax()) {
            if ($role) {
                return Response([
                    'data' => RolePermissionResource::collection($role->permissions)
                ]);
            }

            return Response([
                'error' => [
                    'message' => 'Role not found!'
                ]
            ], 404);
        }

        return !is_null($role) ? $role : null;
    }

    public function createNewUpdate(
        array $arrRoleData,
        string $method = "POST",
        array $arrPermissionData = [],
        int $roleId = 0
    ) {
        $message = [];
        $result = null;
        if ($method === 'POST') {
            $message = [
                'title' => 'Update Role successfully!',
                'message' => 'Role info has been updated!',
                'redirect' => route('admin.roles.index')
            ];
            $result = $this->model->createNew($arrRoleData);
        } else {
            $result = $this->model->updateDataPermissions($roleId, $arrRoleData);
            $message = [
                'title' => 'Update Role successfully!',
                'message' => 'Role info has been updated!',
                'updatedBy' => auth()->guard('admin')->user()->name
            ];
        }

        if ($result) {
            return Response($message);
        }

        return Response([
            'error' => [
                'message' => 'Oops! Something went wrong'
            ]
        ], 500);
    }

    public function updateRolePermissions(int $roleId, array $arrPermissionData)
    {
        $result = $this->model->updateDataPermissions($roleId, [], $arrPermissionData);

        if ($result) {
            $role = $this->model->getDetail($roleId);

            return Response([
                'title' => 'Update Role successfully!',
                'message' => 'Role Permissions has been updated!',
                'updatedBy' => $role->admin->name
            ]);
        }

        return Response([
            'error' => [
                'message' => 'Oops! Something went wrong'
            ]
        ], 500);
    }

    public function destroy(int $roleId)
    {
        $result = $this->model->updateData($roleId, [
            'is_delete' => Constants::DESTROY
        ]);

        if ($result) {
            $this->model->changeRoleAdmin($roleId, 1);

            return Response([
                'title' => 'Update Role successfully!',
                'message' => 'Role info has been updated!'
            ]);
        }

        return Response([
            'error' => [
                'message' => 'Oops! Something went wrong'
            ]
        ], 500);
    }
}
