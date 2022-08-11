<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Module\Post\Models\Post;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function updating_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', ['lang' => 'en', 'post' => Str::slug($res[0])]), ['title' => 'test']);

        $this->assertDatabaseHas('posts', ['title' => 'test']);
    }

    /** @test */
    public function when_title_update_slug_should_update()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', ['lang' => 'en', 'post' => Str::slug($res[0])]), ['title' => 'test']);

        $this->assertDatabaseHas('posts', ['slug' => 'test']);
    }

    /** @test */
    public function handle_length_title_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', ['lang' => 'en', 'post' => Str::slug($res[0])]), ['title' => 'te'])
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_details_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', ['lang' => 'en', 'post' => Str::slug($res[0])]), ['details' => 'test'])
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_description_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', ['lang' => 'en', 'post' => Str::slug($res[0])]), ['description' => 'test test'])
            ->assertStatus(422);
    }
}
