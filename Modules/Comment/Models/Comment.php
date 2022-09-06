<?php

namespace Module\Comment\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    /**
     * Get the parent commentable model (post or ...).
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
