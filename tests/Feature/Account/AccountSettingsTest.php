<?php

namespace Tests\Feature\Account;

use App\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\Feature\FeatureTestCase;

class AccountSettingsTest extends FeatureTestCase
{
    #[Test]
    public function account_settings_page_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/account-settings');

        $response->assertStatus(200);
        $response->assertViewIs('account-settings');
    }
}
