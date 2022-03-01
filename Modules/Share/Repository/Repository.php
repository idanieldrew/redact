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

    /*
     * Paginate $this->model
     * @param int $number
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function paginate($number=10)
    {
        return $this->model->paginate($number);
    }
}