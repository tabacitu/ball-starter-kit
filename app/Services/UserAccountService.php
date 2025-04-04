<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserAccountService
{
    /**
     * Validate profile update data.
     */
    public function validateProfileData(array $data, User $user): array
    {
        return validator($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ])->validate();
    }

    /**
     * Update a user's profile information.
     */
    public function updateProfile(User $user, array $data): User
    {
        $validated = $this->validateProfileData($data, $user);

        $user->fill($validated);

        // If the email was changed, mark it as unverified
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return $user;
    }

    /**
     * Validate password change data.
     */
    public function validatePasswordChange(array $data): array
    {
        return validator($data, [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ])->validate();
    }

    /**
     * Change a user's password.
     */
    public function changePassword(User $user, array $data): bool
    {
        $validated = $this->validatePasswordChange($data);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return true;
    }

    /**
     * Validate account deletion.
     */
    public function validateAccountDeletion(array $data): array
    {
        return validator($data, [
            'password' => ['required', 'current_password'],
        ])->validate();
    }

    /**
     * Delete a user's account.
     */
    public function deleteAccount(User $user, array $data): bool
    {
        $this->validateAccountDeletion($data);

        return $user->delete();
    }

    /**
     * Send a verification email to the user.
     */
    public function sendVerificationEmail(User $user, string $userId, int $perMinute = 5): bool
    {
        if ($user->hasVerifiedEmail()) {
            return false;
        }

        return RateLimiter::attempt(
            'send-verify-email-notification:'.$userId,
            $perMinute,
            function () use ($user) {
                $user->sendEmailVerificationNotification();

                return true;
            }
        );
    }
}
