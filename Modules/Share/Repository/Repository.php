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
   * Destroy $this->model
   * @param string $slug
   * @return void
   */
    public function destroy($param)
    {
        $this->show($param);

        return $this->model->delete($param);
    }
}