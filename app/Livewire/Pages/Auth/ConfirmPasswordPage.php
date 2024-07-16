<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Title;

#[Title('Confirm Password')]
class ConfirmPasswordPage extends AuthComponent
{
    protected string $view = 'livewire.pages.auth.confirm-password-page';

    public string $password = '';

    /**
     * Confirm the user's password.
     */
    public function save()
    {
        if (! Auth::guard('web')->validate([
            'email' => auth()->user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session()->put('auth.password_confirmed_at', time());

        return redirect()->intended($this->defaultRoute);
    }
}
