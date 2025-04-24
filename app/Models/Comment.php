<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

/**
 * @OA\Schema(schema="Comment", description="Комментарий", properties={
 *      @OA\Property(property="id", type="string", description="ID комментария"),
 *      @OA\Property(property="user", type="object", ref="#/components/schemas/UserShort"),
 *      @OA\Property(property="text", type="string", description="Текст комментария"),
 *      @OA\Property(property="createdAt", type="string", format="date-time", description="Время отправки"),
 *      @OA\Property(property="isEdited", type="boolean", description="Метка о редактировании"),
 * })
 */
class Comment extends Model
{
    use HasUuids;

    protected $fillable = [
        'text',
        'post_id',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(fn (self $model) => $model->id = (string) Str::uuid());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function getIsEditedAttribute()
    {
        return $this->created_at !== $this->updated_at;
    }
}
