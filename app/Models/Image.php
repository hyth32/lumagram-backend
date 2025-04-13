<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
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
