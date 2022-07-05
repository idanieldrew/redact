<?php

namespace Module\Category\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Category\Database\Factories\CategoryFactory;
use Module\Media\Models\Media;
use Module\Post\Models\Post;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Create a new factories instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return CategoryFactory::new();
    }

    /* Relations */
    public function images(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    /* Relations */
    public function posts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
