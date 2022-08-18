<?php

namespace Module\User\Observers\v1;

use Module\Role\Models\Role;
use Module\User\Models\User;

class UserObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param \Module\User\Models\User $user
     * @return void
     */
    public function creating(User $user)
    {
        if ($user->role == null) {
            $role = Role::getName('writer')->first();
            $user->role_id = $role->id;
        } else {
            return;
        }
    }
}
