<?php

namespace Module\Share\Repository;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

abstract class Repository
{
    abstract public function model();

    /**
     * Paginate model
     *
     * @param
     * @param  null  $class
     * @param  int  $number
     * @param  bool  $softDelete
     * @return mixed
     */
    public function take($query, $class = null, int $number = 10, bool $softDelete = false): mixed
    {
        if ($class) {
            if (Gate::denies('viewAny', $class)) {
                abort(Response::HTTP_FORBIDDEN);
            }
        }

        return $softDelete ? $query->withTrashed()->paginate($number) : $query->paginate($number);
    }
}
