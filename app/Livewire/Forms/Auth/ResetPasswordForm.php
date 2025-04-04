<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    public $token;
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // This can be customized by the parent component
    public $redirectTo = '/login';

    protected AuthenticationService $authService;

    public function boot(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function mount($token)
    {
        $this->token = $token;
        $this->email = request()->input('email');
    }

    public function save()
    {
        // Reset the user's password
        $status = $this->authService->resetPassword([
            'token' => $this->token,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        // If the password was successfully reset, redirect to the login page with a status message
        if ($status === Password::PASSWORD_RESET) {
            session()->flash('status', __($status));
            return redirect($this->redirectTo);
        }

        $this->addError('email', __($status));
    }

    public function render()
    {
        return view('livewire.forms.auth.reset-password-form');
    }
}
