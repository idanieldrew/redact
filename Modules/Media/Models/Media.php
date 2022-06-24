<?php

namespace Module\Media\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = ['files' => 'json'];

    /** Relations */
    public function imageable()
    {
        return $this->morphTo();
    }
}
