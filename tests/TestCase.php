<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public $user;

    public function setUp()
    {
        parent::setUp();

        // For each test we will setup a fresh testing database

        // Run the migrations
        Artisan::call('migrate:refresh');

        // Call the database seeder, setup any standard records we need
        Artisan::call('db:seed');

        // create a user we can use
        $this->user = $this->createUser();
    }

    public function tearDown()
    {
        // Test done, reset the database
        Artisan::call('migrate:reset');

        parent::tearDown();
    }

    protected function createUser($attributes = [])
    {
        return factory(User::class)->create($attributes);
    }
}
