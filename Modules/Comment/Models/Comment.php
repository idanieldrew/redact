<?php

namespace Module\Comment\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $guarded = [];

    /**
     * Get the parent commentable model (post or ...).
     *
     * @return MorphTo
     */
    public function commentable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    /**
     * For replies
     */
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
