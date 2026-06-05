<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'rating',
    ];

    /**
     * The user (reader) who gave the rating.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The post that was rated.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
