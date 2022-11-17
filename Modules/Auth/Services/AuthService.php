<?php

namespace Module\Auth\Services;

use Module\Share\Service\Service;
use Module\User\Models\User;

class AuthService implements Service
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }
}
