<?php

namespace Module\Share\Repository;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

abstract class Repository
{
    abstract public function model();

    /**
     * Paginate model
     * @param $class
     * @param $query
     * @param int $number
     * @param boolean $softDelete
     * @return Model
     */
    public function take($query, $class = null, int $number = 10, bool $softDelete = false): Model
    {
        if ($class) {
            if (Gate::denies('viewAny', $class)) {
                abort(Response::HTTP_FORBIDDEN);
            }
        }

        return $softDelete ? $query->withTrashed()->paginate($number) : $query->paginate($number);
    }
}
