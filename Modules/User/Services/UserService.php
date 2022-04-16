<?php

namespace Module\User\Services;

use Module\Share\Service\Service;
use Module\User\Models\User;

class UserService implements Service
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