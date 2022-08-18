<?php

namespace Module\Role\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Module\Role\Models\Role;
use Module\User\Models\User;

trait HasRole
{
    use HasPermission;

    /**
     * Relation with user model
     *
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
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
            return $this->role->contains('name', $role);
        } elseif (is_null($role)) {
            return false;
        } elseif (is_int($role)) {
            return (bool)Role::whereId($role)->first();
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

        $user = User::find($this->getKey());
        $user->update([
            'role_id' => $role->id
        ]);
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
