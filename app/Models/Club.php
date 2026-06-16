<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'acronym', 'slug', 'description', 'long_description',
        'president', 'founded_year', 'members_count', 'theme',
        'instagram_url', 'linkedin_url', 'facebook_url', 'website_url',
        'activities',
    ];

    protected $casts = [
        'activities' => 'array',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Tous les membres du club (avec leur rôle via la table pivot).
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'club_user')
            ->withPivot('role', 'is_bureau', 'position')
            ->withTimestamps()
            ->orderByPivot('position');
    }

    /** Membres du bureau uniquement. */
    public function bureau()
    {
        return $this->members()->wherePivot('is_bureau', true);
    }

    /** Membres adhérents (hors bureau). */
    public function adherents()
    {
        return $this->members()->wherePivot('is_bureau', false);
    }

    /** Événements organisés par le club. */
    public function events()
    {
        return $this->hasMany(Event::class)->orderBy('starts_at');
    }
}
