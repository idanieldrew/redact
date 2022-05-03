<?php

namespace Module\Category\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\Category\Database\Factories\CategoryFactory;
use Module\Image\Models\Image;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    /**
     * Create a new factories instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return CategoryFactory::new();
    }
    
    /*** Relation ***/
    public function images()
    {
        return $this->morphMany(Image::class,'imageable');
    }
}
