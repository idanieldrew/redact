<?php

namespace Module\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Role\Traits\HasRole;

class Permission extends Model
{
    use HasFactory, HasRole;

    protected $guarded = [];

    /** Relations */
    /*public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }*/

   /* public function givePermissionTo(string $permission)
    {
        $permission = Permission::query()->where('name', $permission)->first();

        $this->roles()->sync($permission);
        $this->getModel()->load('permissions');
    }*/

    /**
     * Scope a query to first permission of a given name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetName($query, string $name): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('name', $name);
    }
}
