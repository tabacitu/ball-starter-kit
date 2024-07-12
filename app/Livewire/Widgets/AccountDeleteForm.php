<?php

namespace App\Livewire\Widgets;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Livewire\Component;

class AccountDeleteForm extends Component
{
    public $password = '';

    public function destroy(Request $request)
    {
        $this->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // TODO: show global notification

        return $this->redirect('/');
    }

    public function render()
    {
        return view('livewire.widgets.account-delete-form');
    }
}
