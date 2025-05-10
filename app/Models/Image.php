<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(schema="Image", description="Изображение", properties={
 *      @OA\Property(property="mime", type="string", description="Mime тип"),
 *      @OA\Property(property="width", type="integer", description="Ширина изображения"),
 *      @OA\Property(property="height", type="integer", description="Высота изображения"),
 *      @OA\Property(property="url", type="string", description="URL изображения"),
 * })
 */
class Image extends Model
{
    use HasUuids;

    public static function boot()
    {
        parent::boot();

        static::creating(fn (self $model) => $model->id = (string) Str::uuid());
    }

    protected $fillable = [
        'mime_type',
        'width',
        'height',
        'path',
    ];

    public function getStorageUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
