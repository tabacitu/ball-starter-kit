<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
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
     * @param array $credentials The credentials to validate (email, password)
     * @return array The validated credentials
     * @throws \Illuminate\Validation\ValidationException If validation fails
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
     * @param array $credentials The credentials to authenticate with (email, password)
     * @param bool $remember Whether to remember the user
     * @param string|null $ipAddress The IP address of the request (for rate limiting)
     * @throws ValidationException If authentication fails or rate limit is exceeded
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
     * @param string $email The email address being used for login
     * @param string|null $ipAddress The IP address of the request
     * @throws ValidationException If rate limit is exceeded
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
     *
     * @param string $email The email address being used for login
     * @param string|null $ipAddress The IP address of the request
     * @return string The throttle key
     */
    protected function throttleKey(string $email, ?string $ipAddress): string
    {
        $ip = $ipAddress ?? request()->ip();

        return Str::transliterate(Str::lower($email).'|'.$ip);
    }

    /**
     * Validate registration data.
     *
     * @param array $data The registration data to validate (name, email, password, password_confirmation)
     * @return array The validated registration data
     * @throws \Illuminate\Validation\ValidationException If validation fails
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
     * @param array $data The registration data (name, email, password, password_confirmation)
     * @return User The newly created user
     * @throws ValidationException If validation fails
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
     * @param User $user The user to log in
     */
    public function login(User $user): void
    {
        Auth::login($user);
    }

    /**
     * Validate password reset request.
     *
     * @param array $data The password reset request data to validate (email)
     * @return array The validated password reset request data
     * @throws \Illuminate\Validation\ValidationException If validation fails
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
     * @param string $email The email address to send the reset link to
     * @return string The status message from the Password facade
     */
    public function sendPasswordResetLink(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    /**
     * Validate password reset credentials.
     *
     * @param array $data The password reset data to validate (token, email, password, password_confirmation)
     * @return array The validated password reset data
     * @throws \Illuminate\Validation\ValidationException If validation fails
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
     * @param array $credentials The password reset credentials (token, email, password)
     * @return string The status message from the Password facade
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
     * @param User $user The user to mark as verified
     * @return bool True if verification was successful, false otherwise
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
     * @param Request $request The verification request
     * @param User $user The user to verify
     * @return bool True if verification was successful, false otherwise
     */
    public function verifyEmail(Request $request, User $user): bool
    {
        // Check if already verified
        if ($user->hasVerifiedEmail()) {
            return false;
        }

        // Validate the signature
        if (!$request->hasValidSignature()) {
            return false;
        }

        // Check if the hash matches the user's email (additional security)
        if (!hash_equals(sha1($user->email), (string) $request->route('hash'))) {
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
     * @param array $data The password confirmation data to validate (password)
     * @return array The validated password confirmation data
     * @throws \Illuminate\Validation\ValidationException If validation fails
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
     * @param string $email The user's email
     * @param string $password The password to confirm
     * @return bool True if password is valid, false otherwise
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
     * @param Request $request The request instance
     * @return void
     */
    public function logout(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
