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
     *
     * @param array $credentials
     * @return array
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
     * @param array $credentials
     * @param bool $remember
     * @param string|null $ipAddress
     * @return void
     * @throws ValidationException
     */
    public function authenticate(array $credentials, bool $remember = false, ?string $ipAddress = null): void
    {
        $this->ensureIsNotRateLimited($credentials['email'], $ipAddress);

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey($credentials['email'], $ipAddress));

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey($credentials['email'], $ipAddress));

        request()->session()->regenerate();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @param string $email
     * @param string|null $ipAddress
     * @return void
     * @throws ValidationException
     */
    protected function ensureIsNotRateLimited(string $email, ?string $ipAddress): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($email, $ipAddress), 5)) {
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
     *
     * @param string $email
     * @param string|null $ipAddress
     * @return string
     */
    protected function throttleKey(string $email, ?string $ipAddress): string
    {
        $ip = $ipAddress ?? request()->ip();
        return Str::transliterate(Str::lower($email).'|'.$ip);
    }

    /**
     * Validate registration data.
     *
     * @param array $data
     * @return array
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
     *
     * @param array $data
     * @return User
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
     *
     * @param User $user
     * @return void
     */
    public function login(User $user): void
    {
        Auth::login($user);
    }

    /**
     * Validate password reset request.
     *
     * @param array $data
     * @return array
     */
    public function validatePasswordResetRequest(array $data): array
    {
        return validator($data, [
            'email' => ['required', 'email'],
        ])->validate();
    }

    /**
     * Send a password reset link to the user.
     *
     * @param string $email
     * @return string
     */
    public function sendPasswordResetLink(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Validate password reset credentials.
     *
     * @param array $data
     * @return array
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
     *
     * @param array $credentials
     * @return string
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
     *
     * @param User $user
     * @return bool
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
     *
     * @param array $params
     * @param User $user
     * @return bool
     */
    public function verifyEmail(array $params, User $user): bool
    {
        $verificationRequest = new EmailVerificationRequest($params);

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
     * Validate password confirmation.
     *
     * @param array $data
     * @return array
     */
    public function validatePasswordConfirmation(array $data): array
    {
        return validator($data, [
            'password' => ['required'],
        ])->validate();
    }

    /**
     * Confirm the user's password.
     *
     * @param string $email
     * @param string $password
     * @return bool
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
     *
     * @return void
     */
    public function setPasswordConfirmedTimestamp(): void
    {
        session()->put('auth.password_confirmed_at', time());
    }

    /**
     * Log the user out.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
