<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Module\Post\Models\Post;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \Module\Post\Models\Post  $post
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Post $post)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Module\Post\Models\Post  $post
     * @param  \Module\Post\Models\User $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Post $post, $users)
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
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\users  $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, users $users)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\users  $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, users $users)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\users  $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, users $users)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\users  $users
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, users $users)
    {
        //
    }
}
