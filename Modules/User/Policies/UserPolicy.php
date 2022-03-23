<?php

namespace Module\User\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\User\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user)
    {
        if ($user->isSuper()){
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Module\User\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Module\User\Models\User  $user
     * @param  int  $author
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user,$author)
    {
        return $user->id == $author;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Module\User\Models\User $user
     * @param  int $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user,$model)
    {
        return $user->id == $model;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Module\User\Models\User  $user
     * @param  \Module\User\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        return $user->id == $model->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Module\User\Models\User  $user
     * @param  \Module\User\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Module\User\Models\User  $user
     * @param  \Module\User\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model)
    {
        //
    }
}
