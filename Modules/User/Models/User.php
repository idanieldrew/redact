<?php

namespace Module\User\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Module\Category\Models\Category;
use Module\Plan\Models\Subscribe;
use Module\Post\Models\Post;
use Module\Role\Traits\HasRole;
use Module\Share\Traits\UseUuid;
use Module\Status\Models\Status;
use Module\Token\Models\Token;
use Module\User\Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRole, UseUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Create a new factories instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    /* relations */

    public function types()
    {
        return $this->morphMany(Token::class, 'typeable');
    }

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function statuses()
    {
        return $this->morphMany(Status::class, 'statusable');
    }

    public function premiums()
    {
        return $this->belongsToMany(User::class);
    }

    public function tokenz()
    {
        return $this->hasMany(Token::class);
    }

    /** end relations */
    public function getPhoneNumber()
    {
        return $this->phone;
    }

    public function subscribs()
    {
        return $this->hasMany(Subscribe::class);
    }

    public function isVip()
    {
        return match ($this->role->name) {
            'super', 'admin' => true,
            default => false,
        };
    }
}
