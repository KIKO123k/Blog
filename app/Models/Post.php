<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Rating;
use App\Models\Comment;

class Post extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::creating(function (Post $post) {
            if (empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title);
            }
        });

        static::saving(function (Post $post) {
            if (empty($post->slug) && ! empty($post->title)) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    /**
     * Generate a unique slug from a title.
     */
    public static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title) ?: ($excludeId ? 'article-' . $excludeId : 'article');
        $slug = $baseSlug;
        $count = 1;

        while (static::query()
            ->where('slug', $slug)
            ->when($excludeId, fn ($query) => $query->where('id', '!=', $excludeId))
            ->exists()) {
            $slug = $baseSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Backfill slugs for posts that were inserted without model events (e.g. bulk seed).
     */
    public static function backfillMissingSlugs(): int
    {
        $count = 0;

        static::query()
            ->where(fn ($query) => $query->whereNull('slug')->orWhere('slug', ''))
            ->orderBy('id')
            ->chunk(100, function ($posts) use (&$count) {
                foreach ($posts as $post) {
                    $post->slug = static::generateUniqueSlug($post->title, $post->id);
                    $post->saveQuietly();
                    $count++;
                }
            });

        return $count;
    }

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
     * The categories the post belongs to.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_post');
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

    public function resolveRouteBinding($value, $field = null)
    {
        // Accept both numeric ID and slug
        if (is_numeric($value)) {
            return $this->where('id', $value)->firstOrFail();
        }
        return $this->where('slug', $value)->firstOrFail();
    }
}
