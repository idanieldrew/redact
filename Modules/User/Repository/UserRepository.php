<?php

namespace Module\User\Repository;

use Module\Share\Repository\Repository;
use Module\User\Models\User;

class UserRepository extends Repository
{
    public function model()
    {
        return User::query();
    }
}
