<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class PasswordResetTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function forgot_password_page_can_be_rendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertViewIs('auth.forgot-password');
    }

    #[Test]
    public function reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        Livewire::test('forms.auth.forgot-password-form')
            ->set('email', $user->email)
            ->call('save');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    #[Test]
    public function reset_password_link_is_not_sent_to_invalid_email()
    {
        Notification::fake();

        Livewire::test('forms.auth.forgot-password-form')
            ->set('email', 'nonexistent@example.com')
            ->call('save');

        Notification::assertNothingSent();
    }

    #[Test]
    public function reset_password_page_can_be_rendered()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->get('/reset-password/' . $token);

        $response->assertStatus(200);
        $response->assertViewIs('auth.reset-password');
    }

    #[Test]
    public function password_can_be_reset_with_valid_token()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        Livewire::test('forms.auth.reset-password-form', ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save');

        $this->assertTrue(Password::tokenExists($user, $token) === false);

        // Log in with new password
        Livewire::test('forms.auth.login-form')
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->call('save');

        $this->assertAuthenticated();
    }

    #[Test]
    public function password_cannot_be_reset_with_invalid_token()
    {
        $user = User::factory()->create();

        Livewire::test('forms.auth.reset-password-form', ['token' => 'invalid-token'])
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function password_cannot_be_reset_with_invalid_email()
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        Livewire::test('forms.auth.reset-password-form', ['token' => $token])
            ->set('email', 'wrong@example.com')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save')
            ->assertHasErrors('email');

        $this->assertGuest();
    }
}
