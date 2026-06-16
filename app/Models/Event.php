<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'club_id', 'title', 'description', 'location', 'type', 'starts_at', 'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    /** Étudiants inscrits à l'événement. */
    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user')->withTimestamps();
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at->isFuture();
    }

    public function scopeUpcoming($query)
    {
        return $query->where('starts_at', '>=', now()->startOfDay());
    }
}
