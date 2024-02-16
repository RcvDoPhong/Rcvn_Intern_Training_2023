<?php

namespace Modules\Admin\App\Http\Repositories\UserRepository;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getCities();

    public function getDistricts(?int $cityId);

    public function getWards(?int $districtId);

    public function getPaginatedList(array $arrSearchData);

    public function getPaginatedOrdersList(array $arrSearchData, int $userId);

    public function getDetail(int $id);

    public function updateUser(array $arrUserData, int $id);

    public function updatePassword(int $id, array $arrPasswordData);

    public function lockOrDelete(int $id, bool $delete = false);
}
