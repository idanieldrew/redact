<?php

namespace Module\User\Repository\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Module\User\Models\User;
use Module\User\Repository\UserRepository as Repository;

class UserRepository extends Repository
{
    private const TIME = 9000;

    /**
     * Paginate $this->model
     * @param int $number
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $number = 10): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        if (Gate::denies('viewAny', User::class)) {
            abort(403);
        }

        return $this->model()->withTrashed()->paginate($number);
    }

    /**
     * Show $this->model
     * @param int $id
     * @return array|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|User
     */
    public function show(int $id)
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
        return Cache::remember('users.admins', self::TIME, function () {
            return User::query()->whereHas('roles', function (Builder $builder) {
                $builder->where('name', 'writer')->orWhere('name', 'super');
            })->get(['email']);
        });
    }
}
