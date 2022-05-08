<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Post\Models\Post;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use RefreshDatabase,WithFaker;

    /** @test */
    public function read_posts()
    {
        $user = $this->CreateUser();
        $posts = Post::factory(2)->raw();

        $user->posts()->createMany($posts);

        $this->get(route('post.index'))
            ->assertOk();
    }
}