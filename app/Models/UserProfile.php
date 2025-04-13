<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public static function boot()
    {
        parent::boot();

        static::creating(fn (self $model) => $model->id = (string) Str::uuid());
    }
    
    protected $fillable = [
        'name',
        'description',
        'activity_category',
        'is_public',
        'image_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function avatar()
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
