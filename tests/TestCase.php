<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

/**
 * Base test case for the application.
 *
 * Any common setup, teardown, or helper methods for tests can go here.
 */
abstract class TestCase extends BaseTestCase
{
    // You could add a method to set up a test database connection here
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     // e.g., run migrations
    // }
}
