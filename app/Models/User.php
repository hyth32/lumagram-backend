<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(schema="User", description="Профиль", properties={
 *      @OA\Property(property="username", type="string", description="Юзернейм"),
 *      @OA\Property(property="name", type="string", description="Имя"),
 *      @OA\Property(property="description", type="string", description="Описание"),
 *      @OA\Property(property="activityCategory", type="string", description="Категория активности"),
 *      @OA\Property(property="isPublic", type="boolean", description="Метка публичности профиля"),
 *      @OA\Property(property="image", type="string", description="URL изображения"),
 *      @OA\Property(property="postsCount", type="integer", description="Количество публикаций"),
 *      @OA\Property(property="followersCount", type="integer", description="Количество подписчиков"),
 *      @OA\Property(property="followingCount", type="integer", description="Количество подписок"),
 *      @OA\Property(property="isFollowing", type="boolean", description="Метка подписки на пользователя"),
 * })
 * 
 * @OA\Schema(schema="UserShort", description="Профиль", properties={
 *      @OA\Property(property="username", type="string", description="Юзернейм"),
 *      @OA\Property(property="image", type="string", description="URL изображения"),
 * })
 */
class User extends Authenticatable
{
    use HasUuids, SoftDeletes, HasApiTokens, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(fn (self $model) => $model->id = (string) Str::uuid());
    }

    public function getRouteKeyName()
    {
        return 'username';
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function followers()
    {
        return $this->hasMany(Follower::class, 'user_id');
    }

    public function createAccessToken(): string
    {
        return $this->createToken('access-token', ['*'], now()->addDay())->plainTextToken;
    }

    public function createRefreshToken(): string
    {
        return $this->createToken('refresh-token', ['*'], now()->addWeek())->plainTextToken;
    }

    public function createTokens($rememberMe = false): array
    {
        $expirationDate = $rememberMe
            ? now()->addWeek() // refresh
            : now()->addMinutes(15); // access

        return [
            'accessToken' => $this->createAccessToken(),
            'refreshToken' => $this->createRefreshToken(),
            'expirationDate' => $expirationDate,
        ];
    }

    public function setPassword(string $password)
    {
        return $this->forceFill(['password' => Hash::make($password)]);
    }

    public function getFollowersCountAttribute()
    {
        return Follower::getFollowersCount($this->id);
    }

    public function getFollowingCountAttribute()
    {
        return Follower::getFollowingCount($this->id);
    }
}
