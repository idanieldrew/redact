<?php

namespace Module\Post\tests\Feature;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Module\Post\Models\Post;
use Tests\TestCase;

class CrudPostTest extends TestCase
{
    use DatabaseMigrations,WithFaker;

    /** @test */
    public function show_single_post()
    {
        $user = $this->CreateUser();
        $post = $user->posts()->create([
            'title' => $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ]);

        $this->get(route('post.show',$post->slug))
            ->assertSee($post->title)
            ->assertOk();
    }

    /** @test */
    public function incorrect_path_post()
    {
        $user = $this->CreateUser();
        $user->posts()->create([
            'title' => $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ]);

        $this->get(route('post.show',"test"))
            ->assertNotFound();
    }

    /** @test */
    public function store_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id]);

        $this->post(route('post.store'),$post)
            ->assertCreated();
    }

    /** @test */
    public function handle_length_title_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id,'title' => $this->faker->paragraph(5)]);

        $this->post(route('post.store'),$post)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_unique_title_post()
    {
        $user = $this->CreateUser();
        Post::factory()->create(['title' => 'test','user_id' => $user->id]);
        $post = Post::factory()->raw(['user_id' => $user->id,'title' => 'test']);

        $this->post(route('post.store'),$post)
            ->assertStatus(422);
    }
}