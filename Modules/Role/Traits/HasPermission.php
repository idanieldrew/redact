<?php

namespace Module\Role\Traits;

use Module\Role\Models\Permission;
use Module\Role\Models\Role;

trait HasPermission
{
    public function permission(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions');
    }

    public function givePermissionTo(string $permission)
    {
        /*$permission = Permission::query()->where('name', $permission)->first();

        $this->roles()->syncWithPivotValues(get_class(), ['permission_id' => $permission->id]);*/
    }
}
