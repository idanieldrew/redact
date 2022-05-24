<?php

namespace Module\Share\Repository;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

abstract  class  Repository
{
    public abstract function model();

    /**
     * Paginate model
     * @param $class
     * @param $query
     * @param int $number
     * @param boolean $softDelete
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function take($query,$class = null,$number = 10,$softDelete = false)
    {
         if ($class) {
            if (Gate::denies('viewAny', $class)) {
                abort(Response::HTTP_FORBIDDEN);
            }
         }

        return $softDelete ? $query->withTrashed()->paginate($number): $query->paginate($number);
    }
}