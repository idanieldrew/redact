<?php

namespace Module\Category\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\Category\Models\Category;
use Module\User\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Category $categories)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->isUser();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Categories $categories)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Categories $categories)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Categories $categories)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Categories  $categories
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Categories $categories)
    {
        //
    }
}
