<?php

namespace App\Livewire\Forms\Account;

use App\Models\User;
use App\Services\UserAccountService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountInformationForm extends Component
{
    public User $user;

    public string $name;

    public string $email;

    protected UserAccountService $userAccountService;

    public function boot(UserAccountService $userAccountService)
    {
        $this->userAccountService = $userAccountService;
    }

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function sendVerificationEmail(): void
    {
        if ($this->user->hasVerifiedEmail()) {
            return;
        }

        $this->userAccountService->sendVerificationEmail($this->user, $this->user->id);

        session()->flash('status', 'verification-link-sent');  // TODO: show global notification
    }

    public function save(): void
    {
        try {
            $this->userAccountService->updateProfile($this->user, [
                'name' => $this->name,
                'email' => $this->email,
            ]);

            session()->flash('status', 'profile-updated');  // TODO: show global notification
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('email', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.forms.account.account-information-form', [
            'user' => $this->user,
        ]);
    }
}
