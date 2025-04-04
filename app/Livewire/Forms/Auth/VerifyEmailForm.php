<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use App\Services\UserAccountService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VerifyEmailForm extends Component
{
    // This can be customized by the parent component
    public $redirectTo = '/dashboard';

    protected AuthenticationService $authService;

    protected UserAccountService $userAccountService;

    public function boot(AuthenticationService $authService, UserAccountService $userAccountService)
    {
        $this->authService = $authService;
        $this->userAccountService = $userAccountService;
    }

    public function sendVerificationEmail()
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended($this->redirectTo);
        }

        $executed = $this->userAccountService->sendVerificationEmail(
            $user,
            $user->id
        );

        if ($executed) {
            session()->flash('status', 'verification-link-sent');
        } else {
            session()->flash('error', 'Too many attempts! Please try again later');
        }
    }

    public function render()
    {
        return view('livewire.forms.auth.verify-email-form');
    }
}
