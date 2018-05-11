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
        $this->get('/home')
            ->assertRedirect('/login')
            ->assertStatus(302);
    }

    /** @test */
    public function logged_in_user_has_home_page()
    {
        $user = $this->createUser();

        $this->actingAs($user)
            ->get('/home')
            ->assertSee('Dashboard')
            ->assertSee($user->name);
    }
}
