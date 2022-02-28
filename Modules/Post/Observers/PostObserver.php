<?php

namespace Module\Post\Observers;

use Illuminate\Support\Str;
use Module\Post\Models\Post;

class PostObserver
{

    /**
     * Handle the Post "created" event.
     *
     * @param  \Module\Post\Models\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        $post->slug = Str::slug($post->title);
    }
}