<?php

namespace Module\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Image\Models\Image;
use Module\Media\Models\Media;
use Module\Post\Casts\Published;
use Module\Post\Database\Factories\PostFactory;
use Module\Tag\Models\Tag;
use Module\User\Models\User;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'blue_tick' => 'boolean',
        'published' => Published::class
    ];

    /**
     * Create a new factories instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return PostFactory::new();
    }

    /** Relations */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medias(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
