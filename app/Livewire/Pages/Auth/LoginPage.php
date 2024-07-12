<?php

namespace App\Livewire\Pages\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginPage extends AuthComponent
{
    protected string $view = 'livewire.pages.auth.login-page';

    public $email = '';
    public $password = '';
    public $remember = false;

    public function save()
    {
        $loginRequest = new LoginRequest();
        $loginRequest->merge([
                    'email' => $this->email,
                    'password' => $this->password,
                    'remember' => $this->remember,
                ]);
        $loginRequest->authenticate();

        request()->session()->regenerate();

        return redirect()->intended($this->defaultRoute);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
