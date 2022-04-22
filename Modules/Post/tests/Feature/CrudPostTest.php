<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Module\Post\Events\PostPublish;
use Module\Post\Listeners\SendNotificationAdmin;
use Module\Post\Mail\PostPublishedPermission;
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
       $this->withoutExceptionHandling();
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id]);

        $this->post(route('post.store'),$post)
            ->assertCreated();
    }

    /** @test */
    public function required_title_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id,'title' => '']);

        $this->post(route('post.store'),$post)
            ->assertStatus(422);
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

    /** @test */
    public function required_details_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id,'details' => '']);

        $this->post(route('post.store'),$post)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_details_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id,'details' => 'test']);

        $this->post(route('post.store'),$post)
            ->assertStatus(422);
    }

    /** @test */
    public function required_description_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id,'description' => '']);

        $this->post(route('post.store'),$post)
            ->assertStatus(422);
    }

    /** @test */
    public function mock_post_event_mailing()
    {
        Event::fake([
            PostPublish::class
        ]);

        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id]);

        $this->post(route('post.store'),$post)
            ->assertCreated();

        Event::assertDispatched(PostPublish::class);
    }
}