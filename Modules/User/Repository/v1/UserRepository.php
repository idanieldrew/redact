<?php

namespace Module\User\Repository\v1;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Module\User\Http\Resources\v1\UserCollection;
use Module\User\Models\User;
use Module\User\Repository\UserRepository as Repository;

class UserRepository extends Repository
{
    private const TIME = 9000;

    /**
     * Paginate $this->model
     * @param int $number
     * @return UserCollection
     */
    public function paginate(int $number = 10): UserCollection
    {
        return new UserCollection($this->model()->withTrashed()->paginate($number));
    }

    /**
     * Destroy User model
     *
     * @param User $user
     * @return bool
     */
    public function destroy(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Get Admin & super users
     *
     * @return mixed
     */
    public function admins()
    {
        return Cache::remember('users.admins', self::TIME, function () {
            return User::query()->whereHas('role', function (Builder $builder) {
                $builder->where('name', 'admin')->orWhere('name', 'super');
            })->get(['email']);
        });
    }

    /**
     *
     */
    public function simpleUsers()
    {
        return Cache::remember('simple.users', self::TIME, function () {
            return User::query()->whereHas('role', function (Builder $builder) {
                $builder->where('name', 'writer')->cursor();
            })->get(['email']);
        });
    }
}
