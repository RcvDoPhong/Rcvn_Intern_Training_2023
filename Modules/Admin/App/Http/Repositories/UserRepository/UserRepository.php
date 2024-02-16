<?php

namespace Modules\Admin\App\Http\Repositories\UserRepository;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\App\Constructs\Constants;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\User::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getCities()
    {
        return $this->model->getCities();
    }

    public function getDistricts(?int $cityId)
    {
        return $this->model->getDistricts($cityId);
    }

    public function getWards(?int $districtId)
    {
        return $this->model->getWards($districtId);
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getPaginatedOrdersList(array $arrSearchData, int $userId)
    {
        return $this->model->getPaginatedOrdersList($arrSearchData, $userId);
    }

    public function getDetail(int $id)
    {
        $user = $this->model->getDetail($id);

        if (request()->ajax()) {
            return Response([
                'user' => [
                    'name' => $user->name,
                    'nickname' => $user->nickname,
                    'email' => $user->email,
                    'gender' => $user->gender ? 'Nam' : 'Nữ',
                    'isActive' => $user->active === Constants::ADMIN_NON_ACTIVE ? 'Locked' : 'Active',
                    'birthday' => $user->birthday,
                    'createdAt' => date_format(date_create($user->created_at), 'd/m/Y'),
                    'adminName' => $user->admin->name,
                ],
            ]);
        }
        return $user;
    }

    public function updateUser(array $arrUserData, int $id)
    {
        $this->model->updateUser($id, $arrUserData);

        return Response([
            'title' => "Update successfully!",
            'message' => "Update user's info successfully",
            'redirect' => ''
        ]);
    }

    public function updatePassword(int $id, array $arrPasswordData)
    {
        $this->model->updateUser($id, [
            'password' => Hash::make($arrPasswordData['new_password'])
        ]);

        return Response([
            'title' => "Update successfully!",
            'message' => "Update user password successfully",
            'redirect' => route('admin.users.edit', $id)
        ]);
    }

    public function lockOrDelete(int $id, bool $delete = false)
    {
        $field = $delete ? 'is_delete' : 'is_active';

        $this->model->updateUser($id, [
            $field => Constants::ADMIN_NON_ACTIVE
        ]);

        return Response([
            'title' => "Update user's status successfully!",
            'message' => "Update user's status successfully",
        ]);
    }
}
