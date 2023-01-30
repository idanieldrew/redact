<?php

namespace Module\Comment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Share\Traits\UseUuid;

class Comment extends Model
{
    use HasFactory, SoftDeletes, UseUuid;

    protected $guarded = [];

    /**
     * Get the parent commentable model (post or ...).
     *
     * @return MorphTo
     */
    public function commentable(): MorphTo
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
