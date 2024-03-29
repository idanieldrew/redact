<?php

namespace Module\Post\tests\Feature\Comment;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Comment\Models\Comment;
use Tests\CustomTestCase;

class ReplyCommentTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function reply_comment()
    {
        $this->withoutExceptionHandling();
        $post = $this->CreateComment();
        $this->post(route('post.store_comment', $post->slug), ['body' => 'test comment'])
            ->assertCreated();

        $comment = Comment::first();
        $this->post(route('post.reply_comment', [$post->slug, $comment->id]), ['body' => 'reply comment'])
            ->assertCreated();

        $this->assertDatabaseHas('comments', ['parent_id' => $comment->id, 'body' => 'reply comment']);
    }
}
