<?php

namespace Modules\Admin\App\Http\Repositories\AdminRepository;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;
use Modules\Admin\App\Constructs\Constants;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Admin::class;
    }

    public function getAdminList()
    {
        return $this->model->getList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getDetail(int $id)
    {
        return $this->model->getDetailById($id);
    }

    public function createNewUpdate(array $arrAdminData, int $updated_by, string $method = "POST", int $id = 0)
    {
        $message = 'Create new user successfully!';
        $redirect = route('admin.admin.index');

        unset($arrAdminData['_token']);
        if ($method === "POST") {
            $arrAdminData['password'] = Hash::make('password');
            $arrAdminData['updated_by'] = $updated_by;
            $arrAdminData['is_delete'] = Constants::ADMIN_ACTIVE;
            $this->model->create($arrAdminData);
        } else {
            unset($arrAdminData['_method']);
            $arrAdminData['updated_by'] = $updated_by;
            $this->model->updateData($id, $arrAdminData);
            $message = "Update user'is info successfully!";
            $redirect = route('admin.admin.edit', $id);
        }

        return Response([
            'title' => $message,
            'message' => $message,
            'redirect' => $redirect
        ]);
    }

    public function updatePassword(int $id, array $arrPasswords, int $updated_by)
    {
        if (!$this->isIdentityPassword($id, $arrPasswords['old_password'])) {
            return Response([
                'errors' => [
                    'old_password' => 'Old password is not identical.'
                ]
            ], 422);
        }

        $this->model->updateData($id, [
            'password' => Hash::make($arrPasswords['new_password']),
            'updated_by' => $updated_by
        ]);

        return Response([
            'title' => 'Update successfully!',
            'message' => "Updated user's password successfully",
            'redirect' => route('admin.admin.edit', $id)
        ]);
    }

    public function isIdentityPassword(int $id, string $oldPassword)
    {
        return $this->model->isIdentityPassword($id, $oldPassword);
    }

    public function lockOrDelete(int $id, bool $delete = false)
    {
        $message = [];
        $field = '';
        if ($delete) {
            $message = [
                'title' => 'Delete user status successfully!',
                'message' => "User has been deleted successfully!"
            ];
            $field = 'is_delete';
        } else {
            $message = [
                'title' => 'Lock user successfully!',
                'message' => "User has been locked successfully!"
            ];
            $field = 'is_active';
        }

        $this->model->updateData($id, [
            $field => Constants::ADMIN_NON_ACTIVE
        ]);

        return Response($message);
    }

    // public function deleteAdmin(int $id)
    // {
    //     $this->model->deleteAdmin($id);

    //     return Response([
    //         'title' => 'Delete user successfully!',
    //         'message' => "User has been deleted successfully!"
    //     ]);
    // }
}
