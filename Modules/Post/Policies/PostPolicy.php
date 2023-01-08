<?php

namespace Module\Post\Policies;

use Illuminate\Auth\Access\Response;
use Module\Post\Models\Post;
use Module\User\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \Module\User\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role->permissions->contains('name', 'create-post');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    /**
     * admin can update license
     *
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update_license(User $user, Post $post): bool
    {
        if ($user->role->name == 'admin' && $user->id === $post->user_id) {
            return true;
        }
        return false;
    }
}
