<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    /** @test */
    public function secure_controller_requires_login()
    {
        // turn this on, because exception handling is what does the redirect in this case
        $this->withExceptionHandling();

        $this->get('/expense')
            ->assertSee('Expenses')
            ->assertStatus(200);
    }

    /** @test */
    public function logged_in_user_has_home_page()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->get('/expense')
            ->assertSee('Expenses')
            ->assertSee($user->name);
    }
}
