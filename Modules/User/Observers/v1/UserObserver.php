<?php

namespace Module\User\Observers\v1;

use Illuminate\Support\Facades\App;
use Module\Role\Models\Role;
use Module\Token\Services\v1\EmailVerify;
use Module\Token\Services\v1\Verify;
use Module\User\Models\User;

class UserObserver
{
    /**
     * Handle the Post "creating" event.
     *
     * @param  \Module\User\Models\User  $user
     * @return void
     */
    public function creating(User $user)
    {
        if ($user->role == null) {
            $role = Role::getName('writer')->first();
            $user->role_id = $role->id;
        }
    }

    /**
     * Handle the Post "created" event.
     *
     * @param  \Module\User\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $user->statuses()->create([
            'name' => 'pending',
            'reason' => 'needs verification',
        ]);

        if (App::environment('local')) {
            // verify with mobile or mail(mobile is priority)
            $verify = new Verify;
            $verify->verify(new EmailVerify($user->withoutRelations()));
        }
    }
}
