<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test.
     *
     * @test
     */
    public function it_loads_comments_test_page()
    {
        $this->get('/comentario/test')
            ->assertStatus(200)
            ->assertSee("Action Test on CommentController");
    }
}
