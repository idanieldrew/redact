<?php

namespace Module\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Role\Traits\HasPermission;
use Module\Share\Traits\UseUuid;
use Module\User\Models\User;

class Role extends Model
{
    use HasFactory, HasPermission, UseUuid;

    protected $guarded = [];

    /**
     * Scope a query to first permission of a given name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetName($query, $username)
    {
        return $query->where('name', $username);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
