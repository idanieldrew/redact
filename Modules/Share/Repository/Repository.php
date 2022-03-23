<?php

namespace Module\Share\Repository;

abstract class Repository
{
    protected $model;

    abstract public function  model();

    public function __construct()
    {
        $this->model = $this->model();
    }

    public function paginate($number = 10)
    {
        return $this->model->paginate($number);
    }
}