<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ConfirmPasswordForm extends Component
{
    public $password = '';

    // This can be customized by the parent component
    public $redirectTo = '/dashboard';

    protected AuthenticationService $authService;

    public function boot(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function save()
    {
        $this->authService->validatePasswordConfirmation([
            'password' => $this->password,
        ]);

        $confirmed = $this->authService->confirmPassword(
            Auth::user()->email,
            $this->password
        );

        if ($confirmed) {
            $this->authService->setPasswordConfirmedTimestamp();

            return redirect()->intended($this->redirectTo);
        }

        $this->addError('password', __('auth.password'));
    }

    public function render()
    {
        return view('livewire.forms.auth.confirm-password-form');
    }
}
