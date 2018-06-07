<?php

namespace Tests;

use App\User;
use App\Expense;
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
        Artisan::call('db:seed', ['--class' => 'SalesTableSeeder']);

        // create a user we can use
        $this->user = $this->createUser();
        // Create expense
        $this->createExpense();

        $this->withoutExceptionHandling();


    }

    public function createExpense()
    {
        $expense = Expense::create([
            'id' => '1',
            'user_id' => '1',
            'site_id' => '1',
            'supplier' => 'Test Supplier',
            'invoice' => 'Test Invoice',
            'date' => '2018-05-28',
            'cogs_target' => '33',
            'food_cogs_target' => '33',
            'alcohol_cogs_target' => '33',
            'beverage_cogs_target' => '33'
            // other expense details
        ]);
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
