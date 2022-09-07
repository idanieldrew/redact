<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Module\Post\Models\Post;
use Tests\TestCase;

class ReadPostTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function see_posts()
    {
        $this->storePost('writer', false, 3);

        $this->get(route('post.index'))
            ->assertOk();
    }

    /** @test */
    public function reading_post()
    {
        $this->storePost('writer', false, 1, 'test title');

        $this->get(route('post.show', Str::slug('test title')))
            ->assertOk();
    }

    /** @test */
    public function read_post_with_short_link()
    {
        $this->storePost('writer', false, 1, 'test title');

        $post = Post::where('title', 'test title')->first();

        $this->get(route('post.short_link', $post->short_link))
            ->assertRedirect(route('post.show', $post->slug));
    }

    /** @test */
    public function search_posts()
    {
        $this->storePost('writer', false, 1, 'test title');

        $this->getJson(route('post.search', [
            'blue_tick' => false,
            'keyword' => 'test'
        ]))
            ->assertOk()
            ->assertJsonFragment(['title' => 'test title']);
    }
}
