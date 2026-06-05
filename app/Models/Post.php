<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Rating;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'content',
        'user_id',
        'image',
        'slug',
    ];

    /**
     * Get the user (author) that owns the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Auteur anonyme',
        ]);
    }

    /**
     * Get the comments for the blog post.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    /**
    * The ratings given by readers.
    */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
    * Average rating (float) for this post.
    */
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }

    /**
    * Number of rating votes.
    */
    public function getRatingsCountAttribute()
    {
        return $this->ratings()->count();
    }

    /**
     * Use slug for route model binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
