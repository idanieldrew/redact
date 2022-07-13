<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Module\Category\Models\Category;
use Module\Post\Events\PostPublish;
use Module\Post\Listeners\SendNotificationAdmin;
use Module\Post\Mail\PostPublishedPermission;
use Module\Post\Models\Post;
use Tests\TestCase;

class CreatPostTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

    private function storePost()
    {
        $user = $this->CreateUser();
        return $user->posts()->create([
            'title' => $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'banner' => $this->faker->imageUrl
        ]);
    }

    /** @test */
    public function show_single_post()
    {
        $post = $this->storePost();
        $this->get(route('post.show', $post->slug))
            ->assertSee($post->title)
            ->assertOk();
    }

    /** @test */
    public function incorrect_path_post()
    {
        $this->storePost();

        $this->get(route('post.show', "test"))
            ->assertNotFound();
    }

    /** @test */
    public function store_post()
    {
        $this->WithoutEvents();
        $user = $this->CreateUser();
        $categories = Category::factory()->create(['user_id' => auth()->user()]);

        $this->post(route('post.store'), [
            'title' => $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'banner' => $this->faker->imageUrl,
            'category' => [$categories->name],
            'tag_request' => ['tag_1']
        ])
            ->assertValid()
            ->assertCreated();
    }

    /** @test */
    public function required_title_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id, 'title' => '']);

        $this->post(route('post.store'), $post)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_length_title_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id, 'title' => $this->faker->paragraph(5)]);

        $this->post(route('post.store'), $post)
            ->assertStatus(422);
    }

    /** @test */
    public function handle_unique_title_post()
    {
        $user = $this->CreateUser();
        Post::factory()->create(['title' => 'test', 'user_id' => $user->id]);
        $post = Post::factory()->raw(['user_id' => $user->id, 'title' => 'test']);

        $this->post(route('post.store'), $post)
            ->assertInvalid('title');
    }

    /** @test */
    public function required_details_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id, 'details' => '']);

        $this->post(route('post.store'), $post)
            ->assertInvalid('details');
    }

    /** @test */
    public function handle_length_details_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id, 'details' => 'test']);

        $this->post(route('post.store'), $post)
            ->assertInvalid('details');
    }

    /** @test */
    public function required_description_post()
    {
        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id, 'description' => '']);

        $this->post(route('post.store'), $post)
            ->assertInvalid('description');
    }

    /** @test */
    public function store_post_event_mailing_with_mock()
    {
        Event::fake([
            PostPublish::class
        ]);

        $user = $this->CreateUser();
        $post = Post::factory()->raw(['user_id' => $user->id]);

        $this->post(route('post.store'), [
            'title' => $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'banner' => $this->faker->imageUrl,
            'category' => ['category_1'],
            'tag_request' => ['tag_1']
        ])
            ->assertCreated();

        Event::assertDispatched(PostPublish::class);
    }
}
