<?php

namespace Module\Post\tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Module\Category\Models\Category;
use Module\Post\Events\PostPublish;
use Module\Post\Models\Post;
use Str;
use Tests\TestCase;

class CreatPostTest extends TestCase
{
    use DatabaseMigrations, WithFaker;

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

    private function storePost($attachments = false): array
    {
        $img = 'banner.png';
        $extension = '.png';

        $this->WithoutEvents();

        //Create user and category
        $this->CreateUser();
        $categories = Category::factory()->create(['user_id' => auth()->user()]);

        Storage::fake('local');

        $attachments = $attachments ?
            [
                uploadedFile::fake()->image('image1.png'),
                UploadedFile::fake()->image('image2.png')
            ] :
            null;

        $this->post(route('post.store'), [
            'title' => $title = $this->faker->name,
            'details' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'banner' => UploadedFile::fake()->image($img),
            'category' => [$categories->name],
            'tag' => ['tag_1'],
            'attachment' => $attachments
        ])
            ->assertValid()
            ->assertCreated();

        return array($title, $extension);
    }

    /** @test */
    public function store_post_without_attachments()
    {
        $res = $this->storePost();

        Storage::disk('local')->assertExists('public/' . Str::slug($res[0]) . $res[1]);
    }

    /** @test */
    public function store_post_with_attachments()
    {
        $res = $this->storePost(true);

        Storage::disk('local')
            ->assertExists('public/' . Str::slug($res[0]) . $res[1]);

        for ($i = 0; $i <= 2; $i++) {
            $attachments = Storage::disk('local')->listContents('private')[$i];
            preg_match("/(.*?).png/", $attachments['basename'], $match);

            Storage::disk('local')
                ->assertExists(['private/' . $match[0]]);
        }
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
    public function store_event_mailing_with_mock()
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
