<?php

namespace Module\Role\Traits;

use Module\Role\Models\Role;
use Module\User\Models\User;

trait HasRole
{
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
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
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
}
