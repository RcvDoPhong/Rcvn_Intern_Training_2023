<?php

namespace Modules\Admin\App\Http\Repositories\RoleRepository;

use App\Repositories\RepositoryInterface;

interface RoleRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getPermissionList();

    public function getDetail(int $id);

    public function getPaginatedList(array $arrSearchData);

    public function getPermissions(int $roleId);

    public function createNewUpdate(array $arrRoleData, string $method = "POST", array $arrPermissionData = [], int $roleId = 0);

    public function updateRolePermissions(int $roleId, array $arrPermissionData);

    public function destroy(int $roleId);
}
