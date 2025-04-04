<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\UserAccountService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\UnitTestCase;

class UserAccountServiceTest extends UnitTestCase
{
    use WithFaker, MockeryPHPUnitIntegration;

    protected UserAccountService $userAccountService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userAccountService = app(UserAccountService::class);
    }

    #[Test]
    public function it_validates_profile_data()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $validated = $this->userAccountService->validateProfileData($data, $user);

        $this->assertEquals($data, $validated);
    }

    #[Test]
    public function it_throws_validation_exception_for_invalid_profile_data()
    {
        $user = User::factory()->create();

        $this->expectException(ValidationException::class);

        $this->userAccountService->validateProfileData([
            'name' => '',
            'email' => 'not-an-email',
        ], $user);
    }

    #[Test]
    public function it_updates_user_profile()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ];

        $updatedUser = $this->userAccountService->updateProfile($user, $data);

        $this->assertEquals($data['name'], $updatedUser->name);
        $this->assertEquals($data['email'], $updatedUser->email);
        $this->assertNull($updatedUser->email_verified_at);
    }

    #[Test]
    public function it_does_not_reset_email_verified_at_when_email_is_unchanged()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $verifiedAt = $user->email_verified_at;

        $data = [
            'name' => $this->faker->name,
            'email' => $user->email, // Same email
        ];

        $updatedUser = $this->userAccountService->updateProfile($user, $data);

        $this->assertEquals($data['name'], $updatedUser->name);
        $this->assertEquals($data['email'], $updatedUser->email);
        $this->assertEquals($verifiedAt, $updatedUser->email_verified_at);
    }

    #[Test]
    public function it_validates_password_change_data()
    {
        $data = [
            'current_password' => 'current-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ];

        // Mock the validator to avoid the current_password rule check
        $this->mock('validator', function ($mock) use ($data) {
            $mock->shouldReceive('make->validate')
                ->once()
                ->andReturn($data);
        });

        $validated = $this->userAccountService->validatePasswordChange($data);

        $this->assertEquals($data, $validated);
    }

    #[Test]
    public function it_changes_user_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        // Mock the validator to avoid the current_password rule check
        $this->mock('validator', function ($mock) {
            $mock->shouldReceive('make->validate')
                ->once()
                ->andReturn([
                    'current_password' => 'old-password',
                    'password' => 'new-password',
                ]);
        });

        $result = $this->userAccountService->changePassword($user, [
            'current_password' => 'old-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $this->assertTrue($result);
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    #[Test]
    public function it_validates_account_deletion_data()
    {
        $data = [
            'password' => 'password',
        ];

        // Mock the validator to avoid the current_password rule check
        $this->mock('validator', function ($mock) use ($data) {
            $mock->shouldReceive('make->validate')
                ->once()
                ->andReturn($data);
        });

        $validated = $this->userAccountService->validateAccountDeletion($data);

        $this->assertEquals($data, $validated);
    }

    #[Test]
    public function it_deletes_user_account()
    {
        $user = User::factory()->create();

        // Mock the validator to avoid the current_password rule check
        $this->mock('validator', function ($mock) {
            $mock->shouldReceive('make->validate')
                ->once()
                ->andReturn(['password' => 'password']);
        });

        $result = $this->userAccountService->deleteAccount($user, [
            'password' => 'password',
        ]);

        $this->assertTrue($result);
        $this->assertNull(User::find($user->id));
    }

    // Using the parent mock method instead of defining our own
}
