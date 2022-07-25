<?php

namespace Module\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\Role\Models\Permission;
use Module\User\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        $permission = Permission::where('name', 'view-users')->first();

        return $user->hasRole($permission->role_permissions);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param int $author
     * @return bool
     */
    public function view(User $user, int $author): bool
    {
        return $user->id === $author;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param int $model
     * @return bool
     */
    public function update(User $user, int $model): bool
    {
        if (request()->has('role')) {
            return $user->roles->contains('name', 'admin');
        }

        return $user->id === $model;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function delete(User $user, User $model): bool
    {
        return $user->id === $model->id;
    }
}
