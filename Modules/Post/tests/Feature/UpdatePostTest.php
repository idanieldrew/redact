<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdatePostTest extends TestCase
{
    use DatabaseMigrations,WithFaker;

    // store post
    protected function store($title = null)
    {
        $user = $this->CreateUser();
        $post =  $user->posts()->create([
            'title' => $title ? $title : $this->faker->title,
            'details' => $this->faker->paragraph(1),
            'description' => $this->faker->paragraph,
        ]);

        return $post;
    }

    /** @test */
    public function update_post()
    {
        $post = $this->store();

        $this->patch(route('post.update',$post->slug),['title' => 'test']);

        $this->assertDatabaseHas('posts',['title' => 'test']);
    }

    /** @test */
    public function handle_length_title_update_post()
    {
        $post = $this->store();

        $this->patch(route('post.update',$post->slug),['title' => 'te'])
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_details_update_post()
    {
        $post = $this->store();

        $this->patch(route('post.update',$post->slug),['details' => 'test'])
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_description_update_post()
    {
        $post = $this->store();

        $this->patch(route('post.update',$post->slug),['description' => 'test test'])
            ->assertStatus(422);
    }
}