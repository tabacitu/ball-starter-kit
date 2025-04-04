<?php

namespace App\Livewire\Forms\Account;

use App\Services\AuthenticationService;
use App\Services\UserAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AccountDeleteForm extends Component
{
    public $password = '';

    protected UserAccountService $userAccountService;
    protected AuthenticationService $authService;

    public function boot(UserAccountService $userAccountService, AuthenticationService $authService)
    {
        $this->userAccountService = $userAccountService;
        $this->authService = $authService;
    }

    public function destroy(Request $request)
    {
        try {
            $user = $request->user();

            // Delete the account
            $this->userAccountService->deleteAccount($user, [
                'password' => $this->password,
            ]);

            // Log the user out
            $this->authService->logout($request);

            // TODO: show global notification

            return $this->redirect('/');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('password', $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.forms.account.account-delete-form');
    }
}
