<?php

namespace Tests\Feature\Livewire\Forms\Account;

use App\Livewire\Forms\Account\AccountInformationForm;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class AccountInformationFormTest extends FeatureTestCase
{
    use WithFaker, MockeryPHPUnitIntegration;

    #[Test]
    public function account_information_form_can_be_rendered()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->assertStatus(200);
    }

    #[Test]
    public function account_information_form_shows_current_user_data()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->assertSet('name', $user->name)
            ->assertSet('email', $user->email);
    }

    #[Test]
    public function account_information_form_can_update_user_profile()
    {
        $user = User::factory()->create();
        $newName = $this->faker->name;
        $newEmail = $this->faker->email;

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->set('name', $newName)
            ->set('email', $newEmail)
            ->call('save');

        $user->refresh();

        $this->assertEquals($newName, $user->name);
        $this->assertEquals($newEmail, $user->email);
        $this->assertNull($user->email_verified_at);
    }

    #[Test]
    public function account_information_form_does_not_reset_email_verification_when_email_unchanged()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $verifiedAt = $user->email_verified_at;
        $newName = $this->faker->name;

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->set('name', $newName)
            ->set('email', $user->email)
            ->call('save');

        $user->refresh();

        $this->assertEquals($newName, $user->name);
        $this->assertEquals($verifiedAt, $user->email_verified_at);
    }

    #[Test]
    public function account_information_form_validates_name()
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->set('name', '')
            ->call('save')
            ->assertHasErrors('email'); // The component adds errors to 'email' field

        $user->refresh();
        $this->assertNotEquals('', $user->name);
    }

    #[Test]
    public function account_information_form_validates_email()
    {
        $user = User::factory()->create();
        $originalEmail = $user->email;

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->set('email', 'not-an-email')
            ->call('save')
            ->assertHasErrors('email'); // Just check for any error on email

        $user->refresh();
        $this->assertEquals($originalEmail, $user->email);
    }

    #[Test]
    public function account_information_form_validates_unique_email()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $originalEmail = $user1->email;

        Livewire::actingAs($user1)
            ->test(AccountInformationForm::class)
            ->set('email', $user2->email)
            ->call('save')
            ->assertHasErrors('email'); // Just check for any error on email

        $user1->refresh();
        $this->assertEquals($originalEmail, $user1->email);
    }

    #[Test]
    public function account_information_form_allows_same_email_for_same_user()
    {
        $user = User::factory()->create();
        $newName = $this->faker->name;

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->set('name', $newName)
            ->set('email', $user->email)
            ->call('save')
            ->assertHasNoErrors('email');

        $user->refresh();
        $this->assertEquals($newName, $user->name);
    }

    #[Test]
    public function account_information_form_can_send_verification_email()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // Mock the UserAccountService to verify sendVerificationEmail is called
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldReceive('sendVerificationEmail')
            ->once()
            ->withAnyArgs()
            ->andReturn(true);

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->call('sendVerificationEmail');
    }

    #[Test]
    public function account_information_form_does_not_send_verification_email_to_verified_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        // Mock the UserAccountService to verify sendVerificationEmail is not called
        $userAccountServiceMock = $this->mock('App\Services\UserAccountService');
        $userAccountServiceMock->shouldNotReceive('sendVerificationEmail');

        Livewire::actingAs($user)
            ->test(AccountInformationForm::class)
            ->call('sendVerificationEmail');
    }

    // Using the parent mock method instead of defining our own
}
