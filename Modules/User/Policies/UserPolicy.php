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
        return $user->role->permissions->contains('name', 'view-users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param string $author
     * @return bool
     */
    public function view(User $user, string $author): bool
    {
        return $user->username === $author;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param string $model
     * @return bool
     */
    public function update(User $user, string $model): bool
    {
        if (request()->has('role')) {
            return $user->role->name == 'admin';
        }

        return $user->username === $model;
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
        return $user->username === $model->username;
    }
}
