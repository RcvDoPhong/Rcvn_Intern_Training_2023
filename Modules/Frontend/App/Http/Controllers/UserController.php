<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Modules\Frontend\App\Http\Requests\ChangeUserPasswordRequest;
use Modules\Frontend\App\Http\Requests\UpdateUserRequest;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\CityRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\WardRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\DistrictRepositoryInterface;

class UserController extends Controller
{
    private $userRepo;



    public function __construct(
        UserRepositoryInterface $userRepo,

    ) {
        $this->userRepo = $userRepo;
    }

    /**
     * Retrieves the index view for the frontend.
     *
     * @return \Illuminate\Contracts\View\View
     * 15/01/2024
     * version:1
     */
    public function index(Request $request): View|Response
    {

        $userInfor = $this->userRepo->getUserInforDetail();

        return view(
            'frontend::pages.user.index',
            $userInfor
        );
    }

    /**
     * Updates a user with the provided information.
     *
     * @param UpdateUserRequest $request The request object containing the new user information.
     * @throws Some_Exception_Class Exception thrown if an error occurs during the update process.
     * @return Response The response object containing the updated user information.
     * 15/01/2024
     * version:1
     */
    public function update(UpdateUserRequest $request): Response
    {


        $updateInfoArr = $this->userRepo->getInforAfterUpdate($request);

        return new Response([
            "view" => view(
                'frontend::pages.user.index',
                $updateInfoArr
            )->render(),
        ]);
    }

    public function changePasswordPage(Request $request)
    {
        return view('frontend::pages.user.change-password.index');
    }

    /**
     * Changes the password for the user.
     *
     * @param Request $request The HTTP request object.
     * @return Response
     */
    public function changePassword(ChangeUserPasswordRequest $request): Response
    {

        $message = $this->userRepo->changePassword($request);

        return new Response($message);
    }
}
