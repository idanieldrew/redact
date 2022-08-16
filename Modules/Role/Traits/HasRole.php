<?php

namespace Module\Role\Traits;

use Module\Role\Models\Role;

trait HasRole
{
    use HasPermission;

    /**
     * Relation with user model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_has_roles');
    }

    /**
     * Check what's role
     *
     * @param mixed $role
     * @return bool
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        } elseif (is_null($role)) {
            return false;
        }

        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Assign role for user
     *
     * @param string $role
     * @return void
     */
    public function assignRole(string $role)
    {
        $role = Role::where('name', $role)->first();

        $this->roles()->sync($role);
        $this->getModel()->load('roles');
    }

    /**
     * Relation with permission model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function role_permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }
}
