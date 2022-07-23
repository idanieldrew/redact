<?php

namespace Module\Role\Traits;

use Module\Role\Models\Permission;

trait HasPermission
{
    public function permission(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function givePermissionTo(string $permission)
    {
        $permission = Permission::query()->where('name', $permission)->first();

        $this->permissions()->sync($permission);
        $this->getModel()->load('permissions');
    }

    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }
}
