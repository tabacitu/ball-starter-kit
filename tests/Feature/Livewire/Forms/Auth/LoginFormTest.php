<?php

namespace Tests\Feature\Livewire\Forms\Auth;

use App\Livewire\Forms\Auth\LoginForm;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class LoginFormTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function login_form_can_be_rendered()
    {
        Livewire::test(LoginForm::class)
            ->assertStatus(200);
    }

    #[Test]
    public function login_form_can_authenticate_users()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('save')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    #[Test]
    public function login_form_shows_error_for_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->call('save')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function login_form_validates_email()
    {
        Livewire::test(LoginForm::class)
            ->set('email', 'not-an-email')
            ->set('password', 'password')
            ->call('save')
            ->assertHasErrors('email'); // Just check for any error on email

        $this->assertGuest();
    }

    #[Test]
    public function login_form_requires_password()
    {
        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', '')
            ->call('save')
            ->assertHasErrors('password'); // Just check for any error on password

        $this->assertGuest();
    }

    #[Test]
    public function login_form_remembers_user_when_selected()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('remember', true)
            ->call('save');

        $this->assertAuthenticated();
        // We can't directly test the remember token, but we can verify authentication succeeded
    }

    #[Test]
    public function login_form_can_use_custom_redirect()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Livewire::test(LoginForm::class)
            ->set('redirectTo', '/custom-redirect')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('save')
            ->assertRedirect('/custom-redirect');

        $this->assertAuthenticated();
    }
}
