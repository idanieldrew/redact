<?php

namespace Module\User\Repository;

use Illuminate\Support\Facades\Gate;
use Module\Share\Repository\Repository;
use Module\User\Models\User;

class UserRepository extends Repository
{

    /*
     * Specify Model
     * Abstract function
     */
    public function model()
    {
        return User::query();
    }

    /*
    * Paginate $this->model
    * @param int $number
    * @return \Illuminate\Database\Eloquent\Model
    */
    public function paginate($number = 10)
    {
        if (Gate::denies('viewAny',User::class)){
            abort(403);
        }

        return $this->model()->paginate($number);
    }

    /*
    * Destroy $this->model
    * @param string $slug
    * @return void
    */
    public function show($id)
    {
        if (Gate::denies('view', [User::class, $id])) {
            abort(403);
        }

        return $this->model()->findOrFail($id);
    }
}