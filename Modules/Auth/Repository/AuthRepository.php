<?php

namespace Module\Auth\Repository;

use Module\Share\Repository\Repository;
use Module\User\Models\User;

class AuthRepository extends Repository
{
    public function model(): \Illuminate\Database\Eloquent\Builder
    {
        return User::query();
    }
}
