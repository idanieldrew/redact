<?php

namespace Module\Premium\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Module\User\Models\User;

class Premium extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $table = 'premium';

    /* relations */
    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    /** end relations */
}
