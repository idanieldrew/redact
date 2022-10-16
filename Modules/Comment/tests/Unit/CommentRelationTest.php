<?php

namespace Module\Comment\tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Post\Models\Post;
use Tests\CustomTestCase;

class CommentRelationTest extends CustomTestCase
{
    use RefreshDatabase;

    /** @test */
    public function relation_comment_with_post()
    {
        $this->storePost();
        $post = Post::first();

        $this->assertInstanceOf(Collection::class, $post->comments);
    }
}
