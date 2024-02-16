<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\Admin\App\Http\Repositories\AuthRepository\AuthRepositoryInterface;
use Modules\Admin\App\Http\Requests\AdminLoginRequest;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected AuthRepositoryInterface $authRepo;

    public function __construct(AuthRepositoryInterface $authRepo) {
         $this->authRepo = $authRepo;
    }

    public function index()
    {
        return view('admin::pages.auth.index', [
            'title' => 'Sign in'
        ]);
    }

    public function login(AdminLoginRequest $request)
    {
        $loginResult = $this->authRepo->login($request->only('email', 'password'), $request->has('remember'));

        if (!$loginResult['status']) {
            return Redirect::back()->withInput()->withErrors(
                [
                    'message' => $loginResult['message']
                ]
            );
        }

        return redirect()->route('admin.admin.dashboard');
    }

    public function logout(Request $request)
    {
        $this->authRepo->logout($request);

        return redirect()->route('admin.auth.login');
    }
}
