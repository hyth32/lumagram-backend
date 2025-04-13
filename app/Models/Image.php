<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
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
