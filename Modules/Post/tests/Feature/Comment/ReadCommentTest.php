<?php

namespace Module\Post\tests\Feature\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Post\Models\Post;
use Tests\TestCase;

class ReadCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function see_all_comments_for_special_post()
    {
        $this->withoutExceptionHandling();
        $this->storePost();
        $post = Post::first();

        $this->post(route('post.store_comment', $post->slug), ['body' => 'test comment'])
            ->assertCreated();
        $this->post(route('post.store_comment', $post->slug), ['body' => 'test comment 2'])
            ->assertCreated();

        $this->get(route('post.index_comment', $post->slug))
            ->assertOk()
            ->assertSee(["test comment", "test comment 2", "All comment for $post->slug"]);
    }
}
