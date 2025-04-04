<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginForm extends Component
{
    public $email = '';

    public $password = '';

    public $remember = false;

    // This can be customized by the parent component
    public $redirectTo = '/dashboard';

    protected AuthenticationService $authService;

    public function boot(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function save()
    {
        try {
            // Validate credentials
            $credentials = $this->authService->validateLoginCredentials([
                'email' => $this->email,
                'password' => $this->password,
            ]);

            // Authenticate user
            $this->authService->authenticate(
                $credentials,
                $this->remember,
                request()->ip()
            );

            return redirect()->intended($this->redirectTo);
        } catch (ValidationException $e) {
            $this->setErrorBag($e->validator->getMessageBag());
        }
    }

    public function render()
    {
        return view('livewire.forms.auth.login-form');
    }
}
