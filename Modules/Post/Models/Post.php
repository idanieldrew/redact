<?php

namespace Module\Post\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use JeroenG\Explorer\Application\Explored;
use Laravel\Scout\Searchable;
use Module\Category\Models\Category;
use Module\Comment\Models\Comment;
use Module\Media\Models\Media;
use Module\Post\Casts\Published;
use Module\Post\Database\Factories\PostFactory;
use Module\Tag\Models\Tag;
use Module\User\Models\User;

class Post extends Model implements Explored
{
    use HasFactory, SoftDeletes,Searchable;

    protected $fillable = ['title', 'slug', 'details', 'description', 'banner', 'user_id', 'blue_tick'];

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

    /**
     * Get all the post's comments.
     */
    public function comments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function mappableAs(): array
    {
        return [
            'id' => 'keyword',
            'title' => 'text',
            'slug' => 'text',
            'created_at' => 'date',
        ];
    }
}
