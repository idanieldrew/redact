<?php

namespace Module\User\Observers\v1;

use Module\User\Models\User;

class UserObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param \Module\User\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        $user->assignRole('writer');
    }
}
