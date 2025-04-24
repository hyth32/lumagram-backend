<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(schema="Post", description="Пост", properties={
 *      @OA\Property(property="image", type="string", description="URL изображения"),
 *      @OA\Property(property="description", type="string", description="Описание поста"),
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
}
