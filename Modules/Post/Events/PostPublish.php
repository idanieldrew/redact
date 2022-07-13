<?php

namespace Module\Post\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\Post\Models\Post;

class PostPublish
{
    use Dispatchable, SerializesModels;

    private $post;

    /**
     * Get slug($post)
     *
     * @return mixed $post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Create a new event instance.
     *
     * @return void
     * @var Post
     */
    public function __construct($post)
    {
        $this->post = $post;
    }
}
