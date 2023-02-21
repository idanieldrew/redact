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
use Module\Share\Traits\UseUuid;
use Module\Status\Models\Status;
use Module\Tag\Models\Tag;
use Module\User\Models\User;

class Post extends Model implements Explored
{
    use HasFactory, UseUuid, SoftDeletes, Searchable;

    protected $fillable = ['id', 'title', 'slug', 'details', 'description', 'banner', 'user_id', 'blue_tick'];

    protected $with = ['statuses'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'string',
        'blue_tick' => 'boolean',
        //        'published' => Published::class,
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
    public function statuses()
    {
        return $this->morphOne(Status::class, 'statusable');
    }

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

    /**
     * Get the name of the index associated with the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return 'posts';
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     */
    public function getScoutKey()
    {
        return (string)$this->id;
    }

    /**
     * Get the key name used to index the model.
     *
     * @return mixed
     */
    public function getScoutKeyName()
    {
        return (string)'id';
    }

    public function mappableAs(): array
    {
        return [
            'id' => 'text',
            'title' => 'text',
            'slug' => 'text',
            'details' => 'text',
            'created_at' => 'date',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->getKey(),
            'title' => $this->title,
            'slug' => $this->slug,
            'details' => $this->details,
            'created_at' => $this->created_at,
        ];
    }
}
