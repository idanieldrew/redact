<?php

namespace Module\User\Observers\v1;

use Illuminate\Support\Facades\Cache;
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
        }
        return;
    }

    /**
     * Handle the Post "created" event.
     *
     * @param \Module\User\Models\User $user
     * @return void
     */
    public function created(User $user)
    {
        $user->statuses()->create([
            'name' => 'pending',
            'reason' => 'needs verification'
        ]);
    }

}
