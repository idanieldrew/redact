<?php

namespace Module\Post\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\User\Models\User;

class Post extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
