<?php

namespace Modules\Frontend\App\Repositories\Push;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Frontend\App\Models\User;
use Illuminate\Support\Facades\Notification;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Notification\PushNotification;


class PushRepository extends BaseRepository implements PushRepositoryInterface
{


    public function getModel()
    {
        return User::class;
    }

    public function pushUserToUser(Request $request): ?string
    {
        if (Auth::check()) {
            $sentUserID = Auth::user()->user_id;
            $receivedUserID = (int) $request->receive_user_id;
            $body = $request->body;
            $sentUser = $this->model::find($sentUserID);
            $receiveUser = $this->model::find($receivedUserID);
            if (!$receiveUser) {
                return 'User not found';
            }
            Notification::send([$receiveUser], new PushNotification($sentUser, $body));

            return "success";
        }

        return "danger";
    }
    public function pushAdminToUser(int $sentUserID, int $receivedUserID, string $body): ?string
    {
       return null;
    }
}
