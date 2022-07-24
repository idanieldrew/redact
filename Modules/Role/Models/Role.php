<?php

namespace Module\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Role\Traits\HasPermission;

class Role extends Model
{
    use HasFactory, HasPermission;

    protected $guarded = [];
}
