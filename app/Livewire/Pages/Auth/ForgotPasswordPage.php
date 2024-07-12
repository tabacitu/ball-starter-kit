<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ForgotPasswordPage extends AuthComponent
{
    protected string $view = 'livewire.pages.auth.forgot-password-page';

    public string $email = '';

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $validated = $this->validate([
            'email' => ['required', 'email'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink($validated);

        if ($status == Password::RESET_LINK_SENT) {
            session()->flash('status', __($status));
            $this->reset('email');
        } else {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }
    }
}
