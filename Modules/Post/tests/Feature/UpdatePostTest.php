<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\CustomTestCase;

class UpdatePostTest extends CustomTestCase
{
    use DatabaseMigrations, WithFaker;

    /** @test */
    public function updating_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['title' => 'test']);

        $this->assertDatabaseHas('posts', ['title' => 'test']);
    }

    /** @test */
    public function when_title_update_slug_should_update()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['title' => 'test']);

        $this->assertDatabaseHas('posts', ['slug' => 'test']);
    }

    /** @test */
    public function handle_length_title_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['title' => 'te'])
            ->assertJsonValidationErrors("title");
    }

    /** @test */
    public function handle_length_details_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['details' => 'test'])
            ->assertJsonValidationErrors("details");
    }

    /** @test */
    public function handle_length_description_update_post()
    {
        $res = $this->storePost();

        $this->patch(route('post.update', Str::slug($res[0][0])), ['description' => 'test test'])
            ->assertJsonValidationErrors("description");
    }
}
