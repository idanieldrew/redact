<?php

namespace Module\Post\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Category\Models\Category;
use Module\Media\Models\Media;
use Module\Post\Casts\Published;
use Module\Post\Database\Factories\PostFactory;
use Module\Tag\Models\Tag;
use Module\User\Models\User;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'details', 'description', 'banner', 'user_id'];

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
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }

    /** Relations */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Media::class, 'mediaable');
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }
}
