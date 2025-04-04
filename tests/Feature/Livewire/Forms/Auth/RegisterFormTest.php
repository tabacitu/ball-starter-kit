<?php

namespace Tests\Feature\Livewire\Forms\Auth;

use App\Livewire\Forms\Auth\RegisterForm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class RegisterFormTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function register_form_can_be_rendered()
    {
        Livewire::test(RegisterForm::class)
            ->assertStatus(200);
    }

    #[Test]
    public function register_form_can_register_users()
    {
        Event::fake();

        $email = $this->faker->email;

        Livewire::test(RegisterForm::class)
            ->set('name', 'Test User')
            ->set('email', $email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => $email,
        ]);

        Event::assertDispatched(Registered::class);
    }

    #[Test]
    public function register_form_validates_name()
    {
        Livewire::test(RegisterForm::class)
            ->set('name', '')
            ->set('email', $this->faker->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertHasErrors(['name' => 'required']);

        $this->assertGuest();
    }

    #[Test]
    public function register_form_validates_email()
    {
        Livewire::test(RegisterForm::class)
            ->set('name', 'Test User')
            ->set('email', 'not-an-email')
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertHasErrors(['email' => 'email']);

        $this->assertGuest();
    }

    #[Test]
    public function register_form_validates_unique_email()
    {
        $existingUser = User::factory()->create();

        Livewire::test(RegisterForm::class)
            ->set('name', 'Test User')
            ->set('email', $existingUser->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertHasErrors(['email' => 'unique']);

        $this->assertGuest();
    }

    #[Test]
    public function register_form_validates_password()
    {
        Livewire::test(RegisterForm::class)
            ->set('name', 'Test User')
            ->set('email', $this->faker->email)
            ->set('password', '123') // Too short
            ->set('password_confirmation', '123')
            ->call('save')
            ->assertHasErrors(['password']);

        $this->assertGuest();
    }

    #[Test]
    public function register_form_validates_password_confirmation()
    {
        Livewire::test(RegisterForm::class)
            ->set('name', 'Test User')
            ->set('email', $this->faker->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'different-password')
            ->call('save')
            ->assertHasErrors(['password' => 'confirmed']);

        $this->assertGuest();
    }

    #[Test]
    public function register_form_can_use_custom_redirect()
    {
        Event::fake();

        $email = $this->faker->email;

        Livewire::test(RegisterForm::class)
            ->set('redirectTo', '/custom-redirect')
            ->set('name', 'Test User')
            ->set('email', $email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('save')
            ->assertRedirect('/custom-redirect');

        $this->assertAuthenticated();
        Event::assertDispatched(Registered::class);
    }
}
