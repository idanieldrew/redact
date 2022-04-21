<?php

namespace Module\User\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Module\Post\Models\Post;
use Module\User\Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password'
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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const TYPE_ADMIN = 'admin';
    const TYPE_USER= 'user';
    const TYPE_AUTHOR = 'author';
    const TYPE_SUPER = 'super';

    /**
     * Create a new factories instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function isSuper()
    {
        return $this->type == self::TYPE_SUPER;
    }

    public function isAdmin()
    {
        return $this->type == self::TYPE_ADMIN;
    }

    public function isAuthor()
    {
        return $this->type == self::TYPE_AUTHOR;
    }

    public function isUser()
    {
        return $this->type == self::TYPE_USER;
    }

    /** Relations */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function tokenize()
    {
        return $this->hasMany(Token::class);
    }
    /** End */

    public function getPhoneNumber()
    {
        return $this->phone;
    }
}