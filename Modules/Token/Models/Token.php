<?php

namespace Module\Token\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Share\Traits\UseUuid;

class Token extends Model
{
    use HasFactory, UseUuid;

    protected $guarded = [];

    /* relations */

    public function user()
    {
        return $this->belongsTo();
    }
}
