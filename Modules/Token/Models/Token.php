<?php

namespace Module\Token\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    /* relations */

    public function typeable()
    {
        return $this->morphTo();
    }
}
