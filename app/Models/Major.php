<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'modules',
        'access_conditions',
        'duration',
        'video_path',
        'image_path'
    ];

    protected $casts = [
        'modules' => 'array',
    ];

    public function comments()
    {
        return $this->hasMany(MajorComment::class);
    }

    public function ratings()
    {
        return $this->hasMany(MajorRating::class);
    }

    public function avgRating()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }
}