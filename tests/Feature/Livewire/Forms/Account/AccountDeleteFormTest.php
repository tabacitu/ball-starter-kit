<?php

namespace Tests\Feature\Livewire\Forms\Account;

use App\Livewire\Forms\Account\AccountDeleteForm;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class AccountDeleteFormTest extends FeatureTestCase
{
    use WithFaker, MockeryPHPUnitIntegration;

    #[Test]
    public function account_delete_form_can_be_rendered()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(AccountDeleteForm::class)
            ->assertStatus(200);
    }

    #[Test]
    public function account_delete_form_can_delete_account()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);
        $userId = $user->id;

        // Mock the UserAccountService to return success
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('deleteAccount')
            ->once()
            ->with($user, [
                'password' => 'password',
            ])
            ->andReturn(true);

        // Mock the AuthenticationService to handle logout
        $authServiceMock = $this->mock('App\Services\AuthenticationService');
        $authServiceMock->shouldReceive('logout')
            ->once()
            ->with(\Mockery::type(Request::class));

        Livewire::actingAs($user)
            ->test(AccountDeleteForm::class)
            ->set('password', 'password')
            ->call('destroy')
            ->assertRedirect('/');
    }

    #[Test]
    public function account_delete_form_validates_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password'),
        ]);

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('deleteAccount')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountDeleteForm::class)
            ->set('password', 'wrong-password')
            ->call('destroy')
            ->assertHasErrors('password');
    }

    #[Test]
    public function account_delete_form_requires_password()
    {
        $user = User::factory()->create();

        // Mock the UserAccountService to throw validation exception
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('deleteAccount')
            ->once()
            ->andThrow(new \Illuminate\Validation\ValidationException(validator([], [])));

        Livewire::actingAs($user)
            ->test(AccountDeleteForm::class)
            ->set('password', '')
            ->call('destroy')
            ->assertHasErrors('password'); // Just check for any error on password
    }

    // Using the parent mock method instead of defining our own
}
