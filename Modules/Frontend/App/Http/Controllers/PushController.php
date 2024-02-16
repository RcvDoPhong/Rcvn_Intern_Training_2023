<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Modules\Frontend\App\Models\User;
use Modules\Frontend\App\Notification\PushNotification;
use Modules\Frontend\App\Repositories\Push\PushRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Notification;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;

class PushController extends Controller
{

    private $userRepo;
    private $pushRepo;

    public function __construct(UserRepositoryInterface $userRepo, PushRepositoryInterface $pushRepo)
    {
        $this->userRepo = $userRepo;
        $this->pushRepo = $pushRepo;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function subscribeUser(Request $request)
    {
        $this->validate($request, [
            'endpoint' => 'required',
            'keys.auth' => 'required',
            'keys.p256dh' => 'required',
        ]);

        $this->userRepo->subscribeUser($request);

        return response()->json('subscribe success', 200);
    }

    public function pushNotifyUser(Request $request)
    {
        return $this->pushRepo->pushUserToUser($request);
    }
}
