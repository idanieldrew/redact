<?php

namespace Module\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Role\Traits\HasRole;
use Module\Share\Traits\UseUuid;
use Module\User\Models\User;

class Permission extends Model
{
    use HasFactory, HasRole,UseUuid;

    protected $guarded = [];

    /**
     * Scope a query to first permission of a given name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetName($query, string $name): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('name', $name);
    }

    /*public function users()
    {
        return $this->hasManyThrough(User::class, Role::class);
    }*/
}
