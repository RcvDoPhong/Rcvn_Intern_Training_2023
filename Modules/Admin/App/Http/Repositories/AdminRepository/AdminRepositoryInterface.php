<?php

namespace Modules\Admin\App\Http\Repositories\AdminRepository;

use App\Repositories\RepositoryInterface;

interface AdminRepositoryInterface extends RepositoryInterface
{
    public function getAdminList();

    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function createNewUpdate(array $arrAdminData, int $updated_by, string $method = "POST");

    public function isIdentityPassword(int $id, string $oldPassword);

    public function updatePassword(int $id, array $arrPasswords, int $updated_by);

    public function lockOrDelete(int $id, bool $delete = false);
}
