<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

abstract class FeatureTestCase extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Common setup for feature tests
    }

    /**
     * Clean up the testing environment before the next test.
     */
    protected function tearDown(): void
    {
        // Common teardown for feature tests

        parent::tearDown();
    }

    /**
     * Create a user and authenticate them.
     *
     * @param array $attributes
     * @return User
     */
    protected function createAndAuthenticateUser(array $attributes = [])
    {
        $user = User::factory()->create($attributes);
        $this->actingAs($user);

        return $user;
    }
}
