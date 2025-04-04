<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthenticationService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\UnitTestCase;

class AuthenticationServiceTest extends UnitTestCase
{
    use WithFaker;

    protected AuthenticationService $authService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->authService = app(AuthenticationService::class);
    }

    #[Test]
    public function it_validates_login_credentials()
    {
        $credentials = [
            'email' => $this->faker->email,
            'password' => 'password',
        ];

        $validated = $this->authService->validateLoginCredentials($credentials);

        $this->assertEquals($credentials, $validated);
    }

    #[Test]
    public function it_throws_validation_exception_for_invalid_login_credentials()
    {
        $this->expectException(ValidationException::class);

        $this->authService->validateLoginCredentials([
            'email' => 'not-an-email',
            'password' => '',
        ]);
    }

    #[Test]
    public function it_validates_registration_data()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $validated = $this->authService->validateRegistrationData($data);

        $this->assertEquals([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ], $validated);
    }

    #[Test]
    public function it_throws_validation_exception_for_invalid_registration_data()
    {
        $this->expectException(ValidationException::class);

        $this->authService->validateRegistrationData([
            'name' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);
    }

    #[Test]
    public function it_registers_a_new_user()
    {
        Event::fake();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $user = $this->authService->register($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($data['name'], $user->name);
        $this->assertEquals($data['email'], $user->email);
        $this->assertTrue(Hash::check($data['password'], $user->password));

        Event::assertDispatched(Registered::class, function ($event) use ($user) {
            return $event->user->id === $user->id;
        });
    }

    #[Test]
    public function it_validates_password_reset_request()
    {
        $data = [
            'email' => $this->faker->email,
        ];

        $validated = $this->authService->validatePasswordResetRequest($data);

        $this->assertEquals($data, $validated);
    }

    #[Test]
    public function it_throws_validation_exception_for_invalid_password_reset_request()
    {
        $this->expectException(ValidationException::class);

        $this->authService->validatePasswordResetRequest([
            'email' => 'not-an-email',
        ]);
    }

    #[Test]
    public function it_validates_password_reset_credentials()
    {
        $data = [
            'token' => 'token',
            'email' => $this->faker->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $validated = $this->authService->validatePasswordReset($data);

        $this->assertEquals([
            'token' => $data['token'],
            'email' => $data['email'],
            'password' => $data['password'],
        ], $validated);
    }

    #[Test]
    public function it_throws_validation_exception_for_invalid_password_reset_credentials()
    {
        $this->expectException(ValidationException::class);

        $this->authService->validatePasswordReset([
            'token' => '',
            'email' => 'not-an-email',
            'password' => 'short',
            'password_confirmation' => 'different',
        ]);
    }

    #[Test]
    public function it_validates_password_confirmation()
    {
        $data = [
            'password' => 'password',
        ];

        $validated = $this->authService->validatePasswordConfirmation($data);

        $this->assertEquals($data, $validated);
    }

    #[Test]
    public function it_throws_validation_exception_for_invalid_password_confirmation()
    {
        $this->expectException(ValidationException::class);

        $this->authService->validatePasswordConfirmation([
            'password' => '',
        ]);
    }
}
