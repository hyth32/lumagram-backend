<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Post", description="Пост", properties={
 *      @OA\Property(property="id", type="string", description="ID поста"),
 *      @OA\Property(property="user", type="object", ref="#/components/schemas/UserShort", description="Пользователь, опубликовавший пост"),
 *      @OA\Property(property="image", type="string", description="URL изображения"),
 *      @OA\Property(property="description", type="string", description="Описание поста"),
 *      @OA\Property(property="publishedAt", type="string", format="date-time", description="ISO метка публикации"),
 *      @OA\Property(property="likeCount", type="integer", description="Количество лайков"),
 *      @OA\Property(property="commentCount", type="integer", description="Количество комментариев"),
 * })
 */
class Post extends Model
{
    use HasUuids;

    public static function boot()
    {
        parent::boot();

        static::creating(fn (self $model) => $model->id = (string) Str::uuid());
    }

    protected $fillable = [
        'user_id',
        'image_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function image()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
