<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use Livewire\Component;

class RegisterForm extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';

    // This can be customized by the parent component
    public $redirectTo = '/dashboard';

    protected AuthenticationService $authService;

    public function boot(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function save()
    {
        // Register the user
        $user = $this->authService->register([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        // Log the user in
        $this->authService->login($user);

        // Redirect to the dashboard
        return redirect($this->redirectTo);
    }

    public function render()
    {
        return view('livewire.forms.auth.register-form');
    }
}
