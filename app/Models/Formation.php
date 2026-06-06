<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'slug', 'title', 'category', 'type', 'description',
        'objectifs', 'competences', 'debouches', 'programme',
        'acces', 'partenariats', 'source_url', 'duree_annees',
    ];

    protected $casts = [
        'objectifs'    => 'array',
        'competences'  => 'array',
        'debouches'    => 'array',
        'programme'    => 'array',
        'acces'        => 'array',
        'partenariats' => 'array',
    ];

    public function getCategoryLabelAttribute(): string
    {
        return match ($this->category) {
            'preparatoire'      => 'Années Préparatoires',
            'cycle_ingenieur'   => 'Cycle Ingénieur',
            'formation_continue'=> 'Formation Continue',
            'doctorat'          => 'Cycle Doctoral',
            default             => ucfirst($this->category),
        };
    }

    public function comments()
    {
        return $this->hasMany(MajorComment::class, 'major_id');
    }

    public function ratings()
    {
        return $this->hasMany(MajorRating::class, 'major_id');
    }

    public function avgRating()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }
}
