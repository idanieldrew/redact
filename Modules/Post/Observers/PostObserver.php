<?php

namespace Module\Post\Observers;

use Illuminate\Support\Str;
use Module\Post\Models\Post;
use Module\Post\Services\v1\PostService;

class PostObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param  \Module\Post\Models\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
        $service = resolve(PostService::class);

        $post->slug = Str::slug($post->title);
        $post->short_link = $service->generateLink();
    }

    public function created(Post $post)
    {
        $post->statuses()->create([
            'name' => 'pending',
            'reason' => 'pending approval',
        ]);
    }

    /**
     * Handle the Post "updating" event.
     *
     * @param  \Module\Post\Models\Post  $post
     * @return void
     */
    public function updating(Post $post)
    {
        $post->slug = Str::slug($post->title);
    }
}
