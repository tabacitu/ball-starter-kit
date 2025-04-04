<?php

namespace App\Livewire\Forms\Account;

use App\Services\UserAccountService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountChangePasswordForm extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected UserAccountService $userAccountService;

    public function boot(UserAccountService $userAccountService)
    {
        $this->userAccountService = $userAccountService;
    }

    public function save(): void
    {
        try {
            $this->userAccountService->changePassword(Auth::user(), [
                'current_password' => $this->current_password,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation,
            ]);

            $this->reset(['current_password', 'password', 'password_confirmation']);
            session()->flash('status', 'password-updated'); // TODO: show global notification
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('current_password', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.forms.account.account-change-password-form');
    }
}
