<?php

namespace Module\Post\tests\Feature\Comment;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Module\Comment\Models\Comment;
use Module\Post\Models\Post;
use Tests\CustomTestCase;

class CreateCommentTest extends CustomTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_comment_for_post()
    {
        $this->withoutExceptionHandling();
        $this->storePost();
        $post = Post::first();
        $this->post(route('post.store_comment', $post->slug), ['body' => 'test comment'])
            ->assertCreated();

        $comment = Comment::first();

        $this->assertDatabaseHas('comments', ['body' => 'test comment']);
        $this->assertInstanceOf(Post::class, $comment->commentable);
    }

    /** @test */
    public function handle_body_for_create_comment()
    {
        $this->storePost();
        $post = Post::first();
        $this->post(route('post.store_comment', $post->slug), ['body' => 't'])
            ->assertJsonValidationErrors('body');
    }
}
