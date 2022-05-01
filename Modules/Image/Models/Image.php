<?php

namespace Module\Image\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Image\Database\Factories\ImageFactory;
use Module\Post\Models\Post;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [];
    /**
     * Create a new factories instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return ImageFactory::new();
    }

    /** Relations */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}
