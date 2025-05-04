<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @OA\Schema(schema="Follower", description="Подписчик", properties={
 *      @OA\Property(property="username", type="string", description="Юзернейм"),
 *      @OA\Property(property="image", type="string", description="URL изображения"),
 *      @OA\Property(property="isFollowing", type="boolean", description="Метка подписки на подписчика"),
 * })
 */
class Follower extends Model
{
    use HasUuids;

    public static function boot()
    {
        parent::boot();

        static::creating(fn (self $model) => $model->id = (string) Str::uuid());
    }

    protected $fillable = [
        'user_id',
        'follower_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public static function getFollowersCount(string $userId): int
    {
        return self::where('user_id', $userId)->count();
    }

    public static function getFollowingCount(string $userId): int
    {
        return self::where('follower_id', $userId)->count();
    }
}
