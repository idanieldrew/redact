<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyPostTest extends TestCase
{
    use DatabaseMigrations,WithFaker;

    /** @test */
    public function destroy_post()
    {
        $user = $this->CreateUser();

        $post = $user->posts()->create([
            'title' => $this->faker->title,
            'details' => $this->faker->paragraph(1),
            'description' => $this->faker->paragraph,
        ]);

        $this->delete(route('post.destroy',$post->slug))
            ->assertOk();

        $this->assertSoftDeleted('posts',['title' => $post->title]);
    }
}