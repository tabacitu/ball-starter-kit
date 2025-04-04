<?php

namespace Tests\Unit;

use Tests\TestCase;

abstract class UnitTestCase extends TestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Common setup for unit tests
    }

    /**
     * Clean up the testing environment before the next test.
     */
    protected function tearDown(): void
    {
        // Common teardown for unit tests

        parent::tearDown();
    }
}
