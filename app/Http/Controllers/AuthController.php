<?php

namespace App\Http\Controllers;

use App\Services\AuthenticationService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected AuthenticationService $authService;

    protected string $defaultRoute = '/dashboard';

    public function __construct(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function login()
    {
        return view('auth.login');
    }

    /**
     * Show the registration page.
     *
     * @return \Illuminate\View\View
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show the forgot password page.
     *
     * @return \Illuminate\View\View
     */
    public function forgotPassword()
    {
        return view('auth.forgot-password');
    }

    /**
     * Show the reset password page.
     *
     * @param  string  $token
     * @return \Illuminate\View\View
     */
    public function resetPassword($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Show the verify email page.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function verifyEmailNotice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->defaultRoute);
        }

        return view('auth.verify-email');
    }

    /**
     * Show the confirm password page.
     *
     * @return \Illuminate\View\View
     */
    public function confirmPassword()
    {
        return view('auth.confirm-password');
    }

    /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect('/');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param string $id
     * @param string $hash
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyEmail(string $id, string $hash, Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->defaultRoute.'?verified=1');
        }

        $verified = $this->authService->verifyEmail($request, $request->user());

        if (!$verified) {
            return redirect()->route('verification.notice')
                ->with('error', 'The verification link is invalid or has expired.');
        }

        return redirect()->intended($this->defaultRoute.'?verified=1');
    }
}
