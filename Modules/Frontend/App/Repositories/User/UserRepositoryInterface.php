<?php

namespace Modules\Frontend\App\Repositories\User;

use Illuminate\Http\Request;
use Modules\Frontend\App\Models\User;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function register(array $data): ?User;

    public function login(array $data, bool $boolHasRemember): array;

    public function logout(): array;

    public function getUser(int $userID): ?User;

    public function getUserInforDetail(): array;

    public function updateUser(int $userID, array $options = []): ?User;

    public function getInforAfterUpdate(Request $request): array;

    public function isChangeBillingAddress(Request $request): bool;

    public function changePassword(Request $request);

    public function subscribeUser(Request $request);
}
