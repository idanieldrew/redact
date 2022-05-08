<?php

namespace Module\User\Repository;

use Module\Share\Repository\Repository;
use Module\User\Models\User;

class UserRepository extends Repository
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function model()
    {
        return User::query();
    }
}