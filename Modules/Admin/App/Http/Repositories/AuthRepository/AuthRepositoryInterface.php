<?php

namespace Modules\Admin\App\Http\Repositories\AuthRepository;

use App\Repositories\RepositoryInterface;

interface AuthRepositoryInterface extends RepositoryInterface
{
    public function login(array $objLoginData, bool $remember);

    public function logout(object $objAdminData);
}
