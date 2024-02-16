<?php

namespace Modules\Frontend\App\Repositories\Push;

use Illuminate\Http\Request;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface PushRepositoryInterface extends RepositoryInterface
{

    public function pushUserToUser(Request $request): ?string;

    public function pushAdminToUser(int $sentUserID, int $receivedUserID, string $body): ?string;
}
