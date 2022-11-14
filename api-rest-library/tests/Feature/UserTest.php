<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic feature test.
     *
     * @test
     */
    public function it_loads_users_test_page()
    {
        $this->get('/usuario/test')
            ->assertStatus(200)
            ->assertSee("Action Test on UserController");
    }

    /**
     * Feature test for users sing-up.
     *
     * @test
     */
    public function it_loads_users_singup_page()
    {
        $this->post('/api/sing-up')
            ->assertStatus(200)
            ->assertSee("Action SingUp on UserController");
    }

    /**
     * Feature test for users sing-up.
     *
     * @test
     */
    public function it_loads_users_login_page()
    {
        $this->post('/api/login')
            ->assertStatus(200)
            ->assertSee("Action Login on UserController");
    }
}
