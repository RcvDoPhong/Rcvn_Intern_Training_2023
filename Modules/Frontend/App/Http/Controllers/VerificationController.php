<?php

namespace Modules\Frontend\App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/**
 * VerificationController using for verify user's email by sending and confirm
 *
 * 05/01/2024
 * version:2
 */
class VerificationController extends Controller
{

    /**
     * Shows the sent page.
     *
     * @return \Illuminate\Contracts\View\View
     * 05/01/2024
     * version:1
     */
    public function showSentPage(): View
    {
        return view('frontend::pages.email-annouce.index');
    }

    /**
     * Verify the user's email address.
     *
     * @return View
     * 05/01/2024
     * version:1
     */
    public function verifyEmail(): View
    {
        return view('auth.verify-email');
    }

    /**
     * Fulfills the email verification request.
     *
     * @param EmailVerificationRequest $request The email verification request.
     * @return RedirectResponse The redirect response.
     * 05/01/2024
     * version:1
     */
    public function fulfillVerify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/');
    }

    /**
     * Sends a verification email to the user.
     *
     * @param Request $request the HTTP request object
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value the redirect response or success message
     * 05/01/2024
     * version:1
     */
    public function sendVerificationEmail(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check() && !Auth::user()->hasVerifiedEmail()) {
            Auth::user()->sendEmailVerificationNotification();
            // Redirect the user or return a response as needed
            return redirect('/email/sent-page')->with('success', 'Verification email sent successfully.');
        }

        // Redirect the user or return a response if email is already verified
        return redirect()->back()->with('info', 'Your email is already verified.');
    }
}
