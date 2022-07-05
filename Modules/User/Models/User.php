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
use Module\Post\Models\Post;
use Module\Token\Models\Token;
use Module\User\Database\Factories\UserFactory;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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

    private const TYPE_USER = 'user';
    private const TYPE_ADMIN = 'admin';
    private const TYPE_AUTHOR = 'author';
    private const TYPE_SUPER = 'super';

    public static function type_user(): string
    {
        return self::TYPE_USER;
    }
    /**
     * Create a new factories instance for the model.
     *
     * @return Factory
     */
    protected static function newFactory(): Factory
    {
        return UserFactory::new();
    }

    public function isSuper(): bool
    {
        return $this->type === self::TYPE_SUPER;
    }

    public function isAdmin(): bool
    {
        return $this->type === self::TYPE_ADMIN;
    }

    public function isAuthor(): bool
    {
        return $this->type === self::TYPE_AUTHOR;
    }

    public function isUser(): bool
    {
        return $this->type === self::TYPE_USER;
    }

    /** Relations */
    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function tokenize(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
//        dd(10);
        return $this->hasMany(Token::class);
    }

    /** End */

    public function getPhoneNumber()
    {
        return $this->phone;
    }
}
