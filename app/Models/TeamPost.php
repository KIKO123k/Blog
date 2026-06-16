<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamPost extends Model
{
    protected $fillable = [
        'user_id', 'title', 'description', 'skills_needed', 'filiere', 'team_size', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** Compétences sous forme de tableau. */
    public function skillsList(): array
    {
        return array_filter(array_map('trim', explode(',', (string) $this->skills_needed)));
    }
}
