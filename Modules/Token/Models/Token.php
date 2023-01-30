<?php

namespace Module\Token\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Share\Traits\UseUuid;
use Module\Token\Casts\LowerToken;
use Module\User\Models\User;

class Token extends Model
{
    use HasFactory, UseUuid;

    protected $guarded = [];

    protected $casts = [
        'token' => LowerToken::class,
    ];

    /* relations */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
