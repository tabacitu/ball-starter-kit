<?php

namespace App\Livewire\Pages\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Attributes\Title;

#[Title('Verify Email')]
class VerifyEmailPage extends AuthComponent
{
    protected string $view = 'livewire.pages.auth.verify-email-page';

    public function mount(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->defaultRoute);
        }
    }

    /**
     * Mark the authenticated user's email address as verified.
     */
    public function verify(string $id, string $hash, Request $request)
    {
        $input = [
            'id' => $id,
            'hash' => $hash,
            'expires' => $request->expires,
            'signature' => $request->signature,
        ];
        $verificationRequest = new EmailVerificationRequest($input);

        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended($this->defaultRoute.'?verified=1');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->intended($this->defaultRoute.'?verified=1');
    }

    /**
     * Send a new email verification notification.
     */
    public function send(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(self::HOME);
        }

        $executed = RateLimiter::attempt(
            'send-verify-email-notification:'.$request->user()->id,
            $perMinute = 5,
            function() use ($request) {
                $request->user()->sendEmailVerificationNotification();
                session()->flash('status', 'verification-link-sent');
            }
        );

        if (! $executed) {
            abort(429, 'Too many attempts! Please try again later');
        }
    }
}
