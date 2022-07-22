<?php

namespace Module\Role\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Module\Role\Traits\HasRole;

class Permission extends Model
{
    use HasFactory,HasRole;

    protected $guarded = [];

    /** Relations */
   public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions');
    }

    public function givePermissionTo(string $permission)
    {
        $permission = Permission::query()->where('name', $permission)->first();

        $this->roles()->sync($permission);
        $this->getModel()->load('permissions');
    }
}
