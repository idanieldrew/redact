<?php

namespace Module\Tag\Observers;

use Illuminate\Support\Str;
use Module\Tag\Models\Tag;

class TagObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \Module\Tag\Models\Tag $tag
     * @return void
     */
    public function creating(Tag $tag)
    {
        $tag->slug = Str::slug($tag->name);
    }

    /**
     * Handle the Post "updating" event.
     *
     * @param  \Module\Tag\Models\Tag $tag
     * @return void
     */
    public function updating(Tag $tag)
    {
        $tag->slug = Str::slug($tag->name);
    }
}