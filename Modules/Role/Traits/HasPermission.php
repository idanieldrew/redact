<?php

namespace Module\Role\Traits;

use Module\Role\Models\Permission;

trait HasPermission
{
    /**
     * Give permission to role
     *
     * @param ...$permissions
     * @return void
     */
    public function givePermissionTo(...$permissions)
    {
        foreach ($permissions as $permission) {
            if (is_object($permission)) {
                Permission::getName($permission->name)->first();
            } elseif (is_string($permission)) {
                $permission = Permission::getName($permission)->first();
            }

            // Attaching
            $this->permissions()->attach($permission);
            $this->getModel()->load('permissions');
        }
    }

    /**
     * Relation with role model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
