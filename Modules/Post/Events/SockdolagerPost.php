<?php

namespace Module\Post\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Module\Post\Models\Post;

class SockdolagerPost
{
    use Dispatchable, SerializesModels;

    public function __construct(protected Post $post)
    {
    }

    public function getPosts()
    {
        return $this->post;
    }
}
