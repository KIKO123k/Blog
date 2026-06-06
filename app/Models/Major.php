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
        'partenariats', 'source_url', 'video_path',
    ];

    protected $casts = [
        'careers'      => 'array',
        'modules'      => 'array',
        'objectifs'    => 'array',
        'competences'  => 'array',
        'debouches'    => 'array',
        'acces'        => 'array',
        'partenariats'=> 'array',
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
?>