<?php

namespace Module\Token\Repository;

use Module\Share\Repository\Repository;
use Module\User\Models\User;

class TokenRepository extends Repository
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