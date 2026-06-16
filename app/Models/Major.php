<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    // Use the existing formations table
    protected $table = 'formations';

    protected $fillable = [
        'slug', 'title', 'category', 'shortDesc', 'description',
        'duration', 'admission_criteria', 'careers', 'modules',
        'objectifs', 'competences', 'debouches', 'acces',
        'partenariats', 'source_url', 'video_path', 'video_url',
    ];

    protected $casts = [
        'careers'      => 'array',
        'modules'      => 'array',
        'objectifs'    => 'array',
        'competences'  => 'array',
        'debouches'    => 'array',
        'programme'    => 'array',
        'acces'        => 'array',
        'partenariats' => 'array',
    ];

    /**
     * Get the YouTube Embed URL if it's a YouTube link.
     */
    public function getYoutubeEmbedUrlAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        $url = $this->video_url;
        $videoId = null;

        // Matches watch?v=ID or v=ID or youtu.be/ID or embed/ID
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
            $videoId = $match[1];
        }

        return $videoId ? "https://www.youtube.com/embed/{$videoId}" : null;
    }

    public function comments()
    {
        return $this->hasMany(MajorComment::class)->latest();
    }

    public function ratings()
    {
        return $this->hasMany(MajorRating::class);
    }

    /**
     * Helper to compute average rating for the review system.
     */
    public function getAverageRatingAttribute()
    {
        return round($this->avgRating(), 1);
    }

    public function avgRating()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }
}
?>