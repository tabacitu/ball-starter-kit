<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class LoginTest extends FeatureTestCase
{
    use WithFaker;

    #[Test]
    public function login_page_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }

    #[Test]
    public function users_can_authenticate_using_the_login_form()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Livewire::test('forms.auth.login-form')
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('save')
            ->assertRedirect('/dashboard');

        $this->assertAuthenticated();
    }

    #[Test]
    public function users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        Livewire::test('forms.auth.login-form')
            ->set('email', 'test@example.com')
            ->set('password', 'wrong-password')
            ->call('save')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function users_can_not_authenticate_with_invalid_email()
    {
        Livewire::test('forms.auth.login-form')
            ->set('email', 'nonexistent@example.com')
            ->set('password', 'password')
            ->call('save')
            ->assertHasErrors('email');

        $this->assertGuest();
    }

    #[Test]
    public function users_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $this->assertAuthenticated();

        $response = $this->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    #[Test]
    public function user_cannot_access_dashboard_when_not_authenticated()
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    #[Test]
    public function user_can_access_dashboard_when_authenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    #[Test]
    public function user_cannot_access_login_page_when_authenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }

    #[Test]
    public function user_cannot_access_register_page_when_authenticated()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/register');

        $response->assertRedirect('/dashboard');
    }
}
