<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

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
            : now()->addDay(); // access

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
}
