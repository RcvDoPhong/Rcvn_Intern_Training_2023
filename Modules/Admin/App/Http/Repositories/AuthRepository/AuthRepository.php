<?php

namespace Modules\Admin\App\Http\Repositories\AuthRepository;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Admin::class;
    }

    public function login(array $objLoginData, bool $remember)
    {
        if ($this->model->isUserLockOrDelete($objLoginData['email'])) {
            return [
                'status' => false,
                'message' => 'Account has been deleted or locked'
            ];
        }

        if (Auth::guard('admin')->attempt($objLoginData, $remember)) {
            return [
                'status' => true,
                'message' => 'Login successfully'
            ];
        }

        return [
            'status' => false,
            'message' => 'Email or password is incorrect'
        ];
    }

    public function logout(object $objAdminData)
    {
        Auth::guard('admin')->logout();
    }
}
