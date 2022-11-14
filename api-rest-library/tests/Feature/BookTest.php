<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    /**
     * A basic feature test.
     *
     * @test
     */
    public function it_loads_books_test_page()
    {
        $this->get('/libro/test')
            ->assertStatus(200)
            ->assertSee("Action Test on BookController");
    }
}
