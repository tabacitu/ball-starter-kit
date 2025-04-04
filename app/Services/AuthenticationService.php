<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthenticationService
{
    /**
     * Validate login credentials.
     */
    public function validateLoginCredentials(array $credentials): array
    {
        return validator($credentials, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ])->validate();
    }

    /**
     * Authenticate a user with the provided credentials.
     *
     * @throws ValidationException
     */
    public function authenticate(array $credentials, bool $remember = false, ?string $ipAddress = null): void
    {
        $this->ensureIsNotRateLimited($credentials['email'], $ipAddress);

        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey($credentials['email'], $ipAddress));

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($credentials['email'], $ipAddress));

        // Only regenerate the session if it's available (not in certain test scenarios)
        if (request()->hasSession()) {
            request()->session()->regenerate();
        }
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws ValidationException
     */
    protected function ensureIsNotRateLimited(string $email, ?string $ipAddress): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($email, $ipAddress), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey($email, $ipAddress));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    protected function throttleKey(string $email, ?string $ipAddress): string
    {
        $ip = $ipAddress ?? request()->ip();

        return Str::transliterate(Str::lower($email).'|'.$ip);
    }

    /**
     * Validate registration data.
     */
    public function validateRegistrationData(array $data): array
    {
        return validator($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])->validate();
    }

    /**
     * Register a new user.
     */
    public function register(array $data): User
    {
        $validated = $this->validateRegistrationData($data);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        return $user;
    }

    /**
     * Log in a user.
     */
    public function login(User $user): void
    {
        Auth::login($user);
    }

    /**
     * Validate password reset request.
     */
    public function validatePasswordResetRequest(array $data): array
    {
        return validator($data, [
            'email' => ['required', 'email'],
        ])->validate();
    }

    /**
     * Send a password reset link to the user.
     */
    public function sendPasswordResetLink(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Validate password reset credentials.
     */
    public function validatePasswordReset(array $data): array
    {
        return validator($data, [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ])->validate();
    }

    /**
     * Reset the user's password.
     */
    public function resetPassword(array $credentials): string
    {
        return Password::reset(
            $credentials,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );
    }

    /**
     * Mark the user's email as verified.
     */
    public function markEmailAsVerified(User $user): bool
    {
        if ($user->hasVerifiedEmail()) {
            return false;
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            return true;
        }

        return false;
    }

    /**
     * Verify email with verification request.
     */
    public function verifyEmail(array $params, User $user): bool
    {
        if ($user->hasVerifiedEmail()) {
            return false;
        }

        // Check if the hash matches the user's email
        if (! hash_equals(sha1($user->email), $params['hash'])) {
            return false;
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));

            return true;
        }

        return false;
    }

    /**
     * Validate password confirmation.
     */
    public function validatePasswordConfirmation(array $data): array
    {
        return validator($data, [
            'password' => ['required'],
        ])->validate();
    }

    /**
     * Confirm the user's password.
     */
    public function confirmPassword(string $email, string $password): bool
    {
        return Auth::guard('web')->validate([
            'email' => $email,
            'password' => $password,
        ]);
    }

    /**
     * Set the password confirmation timestamp.
     */
    public function setPasswordConfirmedTimestamp(): void
    {
        session()->put('auth.password_confirmed_at', time());
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
