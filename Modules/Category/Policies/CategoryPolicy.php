<?php

namespace Module\Category\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\Category\Models\Category;
use Module\Role\Models\Permission;
use Module\User\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param \Module\User\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function createOrUpdate(User $user)
    {
        return $user->role->permissions->contains('name', 'create-category');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Categories $categories)
    {
    }

}
