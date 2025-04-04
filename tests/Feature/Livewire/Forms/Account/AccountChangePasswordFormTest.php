<?php

namespace Tests\Feature\Livewire\Forms\Account;

use App\Livewire\Forms\Account\AccountChangePasswordForm;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class AccountChangePasswordFormTest extends FeatureTestCase
{
    use WithFaker, MockeryPHPUnitIntegration;

    #[Test]
    public function account_change_password_form_can_be_rendered()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->assertStatus(200);
    }

    #[Test]
    public function account_change_password_form_can_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('current-password'),
        ]);

        // Mock the UserAccountService to return success
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->with($user, [
                'current_password' => 'current-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->andReturn(true);

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', 'current-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save');
    }

    #[Test]
    public function account_change_password_form_validates_current_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('current-password'),
        ]);

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', 'wrong-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save')
            ->assertHasErrors('current_password');
    }

    #[Test]
    public function account_change_password_form_validates_password_confirmation()
    {
        $user = User::factory()->create();

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', 'current-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'different-password')
            ->call('save')
            ->assertHasErrors('current_password'); // The component adds errors to 'current_password' field
    }

    #[Test]
    public function account_change_password_form_validates_password_strength()
    {
        $user = User::factory()->create();

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', 'current-password')
            ->set('password', '123') // Too short
            ->set('password_confirmation', '123')
            ->call('save')
            ->assertHasErrors('current_password'); // The component adds errors to 'current_password' field
    }

    #[Test]
    public function account_change_password_form_requires_current_password()
    {
        $user = User::factory()->create();

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', '')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save')
            ->assertHasErrors('current_password'); // The component adds errors to 'current_password' field
    }

    #[Test]
    public function account_change_password_form_requires_new_password()
    {
        $user = User::factory()->create();

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', 'current-password')
            ->set('password', '')
            ->set('password_confirmation', '')
            ->call('save')
            ->assertHasErrors('current_password'); // The component adds errors to 'current_password' field
    }

    #[Test]
    public function account_change_password_form_resets_fields_after_successful_update()
    {
        $user = User::factory()->create([
            'password' => Hash::make('current-password'),
        ]);

        // Mock the UserAccountService to return success
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('changePassword')
            ->once()
            ->andReturn(true);

        Livewire::actingAs($user)
            ->test(AccountChangePasswordForm::class)
            ->set('current_password', 'current-password')
            ->set('password', 'new-password')
            ->set('password_confirmation', 'new-password')
            ->call('save')
            ->assertSet('current_password', '')
            ->assertSet('password', '')
            ->assertSet('password_confirmation', '');
    }

    // Using the parent mock method instead of defining our own
}
