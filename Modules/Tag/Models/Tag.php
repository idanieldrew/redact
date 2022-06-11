<?php

namespace Module\Tag\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Tag\Database\Factories\TagFactory;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    /**
     * Create a new factories instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TagFactory::new();
    }

    /*** Relations */
    public function posts()
    {
        return $this->belongsToMany(Tag::class);
    }
}