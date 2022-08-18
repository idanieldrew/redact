<?php

namespace Module\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Role\Traits\HasPermission;
use Module\User\Models\User;

class Role extends Model
{
    use HasFactory, HasPermission;

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
