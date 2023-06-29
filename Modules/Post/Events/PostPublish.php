<?php

namespace Module\Post\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\InteractsWithSockets;
use Module\Post\Models\Post;

class PostPublish
{
    use Dispatchable, SerializesModels;

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
     *
     * @var Post
     */
    public function __construct(public $post)
    {
    }
}
