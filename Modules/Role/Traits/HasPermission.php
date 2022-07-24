<?php

namespace Module\Role\Traits;

use Module\Role\Models\Permission;

trait HasPermission
{
    public function givePermissionTo($permission)
    {
        if (is_object($permission)) {
            Permission::getName($permission->name)->first();
        } elseif (is_string($permission)) {
            Permission::getName($permission)->first();
        }

        $this->permissions()->sync($permission);
        $this->getModel()->load('permissions');
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
