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
        $post = $user->posts()->create([
            'title' => $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ]);

        $this->get(route('post.show',"test"))
            ->assertNotFound();
    }
}