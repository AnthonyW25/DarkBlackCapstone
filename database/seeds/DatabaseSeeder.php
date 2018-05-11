<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Set up a Test User
        // This isn't needed for automated tests because we can use $this->createUser() in our tests
        $user = \App\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'remember_token' => str_random(10),
        ]);

        // Later we may setup other default items we need for manual testing
    }
}
