<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class RegistrationTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function registration_page_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    #[Test]
    public function new_users_can_register()
    {
        Event::fake();

        Livewire::test('forms.auth.register-form')
            ->set('name', 'Test User')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);

        Event::assertDispatched(Registered::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    #[Test]
    public function user_cannot_register_with_invalid_email()
    {
        Livewire::test('forms.auth.register-form')
            ->set('name', 'Test User')
            ->set('email', 'invalid-email')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function user_cannot_register_with_invalid_password()
    {
        Livewire::test('forms.auth.register-form')
            ->set('name', 'Test User')
            ->set('email', $this->faker->email)
            ->set('password', '123') // Too short
            ->set('password_confirmation', '123')
            ->call('save')
            ->assertHasErrors('password');

        $this->assertGuest();
    }

    #[Test]
    public function user_cannot_register_with_mismatched_passwords()
    {
        Livewire::test('forms.auth.register-form')
            ->set('name', 'Test User')
            ->set('email', $this->faker->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'different-password')
            ->call('save')
            ->assertHasErrors('password');

        $this->assertGuest();
    }
}
