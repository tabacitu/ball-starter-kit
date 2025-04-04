<?php

namespace App\Livewire\Forms\Auth;

use App\Services\AuthenticationService;
use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPasswordForm extends Component
{
    public $email = '';

    protected AuthenticationService $authService;

    public function boot(AuthenticationService $authService)
    {
        $this->authService = $authService;
    }

    public function save()
    {
        // Validate the email
        $validated = $this->authService->validatePasswordResetRequest([
            'email' => $this->email,
        ]);

        // Send the password reset link
        $status = $this->authService->sendPasswordResetLink($validated['email']);

        if ($status === Password::RESET_LINK_SENT) {
            $this->reset('email');
        }

        session()->flash('status', __($status));
    }

    public function render()
    {
        return view('livewire.forms.auth.forgot-password-form');
    }
}
