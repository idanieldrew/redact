<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Module\Category\Models\Category;
use Module\Post\Models\Post;
use function PHPSTORM_META\type;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function see_posts()
    {
        $this->storePost('writer', false, 3);

        $this->get(route('post.index', ['lang' => 'en']))
            ->assertOk();
    }

    /** @test */
    public function read_post()
    {
        $this->storePost('writer', false, 1, 'test title');

        $this->get(route('post.show', ['lang' => 'en', 'post' => Str::slug('test title')]))
            ->assertOk();
    }

    /** @test */
    public function search_posts()
    {
        /*$user = $this->CreateUser();
        $posts = Post::factory()->count(20)->raw();
        $post = Post::factory()->count(1)->raw(['title' => 'test two']);

        $user->posts()->createMany($posts);
        $user->posts()->createMany($post);*/
        $this->withoutExceptionHandling();
        $this->storePost('writer', false, 1, 'test title');

        $this->getJson(route('post.search', ['lang' => 'en']) . '? keyword=test')
            ->assertOk()
            ->assertJsonFragment(['title' => 'test title']);
    }
}
