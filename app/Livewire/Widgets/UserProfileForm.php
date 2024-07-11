<?php

namespace App\Livewire\Widgets;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class UserProfileForm extends Component
{
    public User $user;
    public string $name;
    public string $email;

    public function mount(): void
    {
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }

    public function sendVerificationEmail(): void
    {
        if ($this->user->hasVerifiedEmail()) {
            return;
        }

        $this->user->sendEmailVerificationNotification();

        session()->flash('status', 'verification-link-sent');  // TODO: show global notification
    }

    public function save(): void
    {
        $validatedData = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user->id)],
        ]);

        $this->updateUserInfo($validatedData);

        session()->flash('status', 'profile-updated');  // TODO: show global notification
    }

    private function updateUserInfo(array $validatedData): void
    {
        $this->user->fill($validatedData);

        // if the email was changed, mark the address as unverified
        if ($this->user->isDirty('email')) {
            $this->user->email_verified_at = null;
        }

        $this->user->save();
    }

    public function render()
    {
        return view('livewire.widgets.user-profile-form', [
            'user' => $this->user,
        ]);
    }
}
