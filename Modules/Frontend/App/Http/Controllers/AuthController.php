<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;

/**
 * AuthController for authenticate user in frontend pages
 *
 * 4/1/2023
 * version:1
 */
class AuthController extends Controller
{

    private $userRepo;
    private $cartRepo;

    public function __construct(UserRepositoryInterface $userRepo, CartRepositoryInterface $cartRepo)
    {
        $this->userRepo = $userRepo;
        $this->cartRepo = $cartRepo;
    }

    /**
     * Retrieves the index view for the login page.
     *
     * @throws Some_Exception_Class if the view cannot be found
     * @return \Illuminate\Contracts\View\View the index view for the login page
     * 4/1/2023
     * version:1
     */
    public function index()
    {
        return view('frontend::pages.auth.login.index');
    }


    /**
     * Create a new resource.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function create()
    {
        return view('frontend::pages.auth.register.index');
    }

    /**
     * Store the user registration details.
     *
     * @param Request $request The HTTP request object.
     * @throws \Some_Exception_Class Description of exception
     * @return Response The HTTP response object.
     * 4/1/2023
     * version:1
     */
    public function store(Request $request): Response
    {

        $arrData = Validator::make($request->all(), [
            "email" => "required|email|unique:users,email",
            "password" => "required|min:6|confirmed",
            "name" => 'required|min:2|max:256'
        ]);

        if ($arrData->fails()) {
            return new Response([
                'status' => 400,
                'errors' => $arrData->errors()
            ]);
        }

        $this->userRepo->register($request->only(['email', 'password', 'name']));

        return new Response([
            'status' => 200,
            'redirect' => route('frontend.auth.index')
        ]);
    }

    /**
     * Logs in a user.
     *
     * @param Request $request The request object containing the user's login credentials.
     * @throws \Some_Exception_Class If there is an error during login.
     * @return Response The response object containing the login result.
     * 4/1/2023
     * version:1
     */
    public function login(Request $request): Response
    {

        $data = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);
        $boolHasRemember = $request->input('remember') === "true" ? true : false;

        if ($data->fails()) {
            return new Response([
                'status' => 400,
                'errors' => $data->errors()
            ]);
        }




        $arrData = $this->userRepo->login($request->only(['email', 'password']), $boolHasRemember);


        if ($arrData['status'] === 200) {
            $this->cartRepo->updateCartAfterLogin($arrData['user']['user_id']);
        }

        return new Response($arrData);
    }

    /**
     * Logout the user.
     *
     * @param Request $request The request object.
     * @throws \Some_Exception_Class An exception that may occur during the logout process.
     * @return Response The response object.
     *   4/1/2023
     * version:1
     */
    public function logout(Request $request): Response
    {
        $messageData = $this->userRepo->logout();

        return new Response($messageData);
    }


    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        // return view('frontend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //return view('frontend::edit');
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    }
}
