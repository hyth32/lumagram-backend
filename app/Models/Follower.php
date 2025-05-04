<?php

namespace App\Models;

use Application\Enums\FollowStatus;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @OA\Schema(schema="Follower", description="Подписчик", properties={
 *      @OA\Property(property="username", type="string", description="Юзернейм"),
 *      @OA\Property(property="image", type="string", description="URL изображения"),
 *      @OA\Property(property="followingStatus", type="string", description="Статус подписки на подписчика"),
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
        return self::query()
            ->where('user_id', $userId)
            ->where('status', FollowStatus::Followed->value())
            ->count();
    }

    public static function getFollowingCount(string $userId): int
    {
        return self::query()
            ->where('follower_id', $userId)
            ->where('status', FollowStatus::Followed->value())
            ->count();
    }

    public static function getFollowingStatus(string $subjectId, string $followerId)
    {
        if ($followerId == $subjectId) {
            return null;
        }
        
        $followRecord = self::findRecord($subjectId, $followerId)->first();

        if (empty($followRecord)) {
            return null;
        }

        return FollowStatus::getLabelFromValue($followRecord->status);
    }

    public static function findRecord(string $subjectId, string $followerId)
    {
        if ($followerId == $subjectId) {
            return null;
        }
        
        return self::where('user_id', $subjectId)->where('follower_id', $followerId);
    }

    public static function findFollowRecord(string $subjectId, string $followerId)
    {
        $followRecord = self::findRecord($subjectId, $followerId);
        if (empty($followRecord)) {
            return null;
        }

        return $followRecord
            ->where('status', FollowStatus::Followed->value())
            ->first();
    }

    public static function findPendingRecord(string $subjectId, string $followerId)
    {
        $followRecord = self::findRecord($subjectId, $followerId);
        if (empty($followRecord)) {
            return null;
        }

        return $followRecord
            ->where('status', FollowStatus::Pending->value())
            ->first();
    }
}
