<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Category\Models\Category;
use Module\Post\Models\Post;
use function PHPSTORM_META\type;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function read_posts()
    {
        $user = $this->CreateUser();
        $posts = Post::factory(2)->raw();

        $user->posts()->createMany($posts);

        $this->get(route('post.index'))
            ->assertOk();
    }

    /** @test */
    public function search_posts()
    {
        $user = $this->CreateUser();
        $posts = Post::factory()->count(20)->raw();
        $post = Post::factory()->count(1)->raw(['title' => 'test two']);

        $user->posts()->createMany($posts);
        $user->posts()->createMany($post);

        $this->getJson(route('post.search') . '? keyword=test')
            ->assertOk()
            ->assertJsonFragment(['title' => 'test two']);
    }
}