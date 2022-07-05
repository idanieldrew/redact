<?php

namespace Module\User\Repository\v1;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Module\User\Models\User;
use Module\User\Repository\UserRepository as Repository;

class UserRepository extends Repository
{
    /**
     * Paginate $this->model
     * @param int $number
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function paginate($number = 10)
    {
        if (Gate::denies('viewAny', User::class)) {
            abort(403);
        }

//        return $this->model()->paginate($number);

        return $this->model()->withTrashed()->paginate($number);
    }

    /**
     * Show $this->model
     * @param int $id
     * @return User
     */
    public function show($id)
    {
        if (Gate::denies('view', [User::class, $id])) {
            abort(403);
        }

        return $this->model()->findOrFail($id);
    }

    /**
     * Destroy User model
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user): bool
    {
        if (Gate::denies('delete', [User::class, $user])) {
            abort(Response::HTTP_FORBIDDEN);
        }

        return $user->delete();
    }

    /**
     * Get Admin & superusers
     *
     */
    public function admins()
    {
        return Cache::remember('user.admins', 9000, function () {
            return User::query()
                ->where('type', 'admin')
                ->orWhere('type', 'super')
                ->get(['email']);
        });
    }
}
