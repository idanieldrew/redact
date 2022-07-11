<?php

namespace Module\User\Services;

use Module\Share\Service\Service;
use Module\User\Models\User;

class UserService implements Service
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }
}
