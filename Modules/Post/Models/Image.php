<?php

namespace Module\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Post\Database\Factories\ImageFactory;

class Image extends Model
{
    use HasFactory;

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
