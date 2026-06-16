<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    protected $fillable = [
        'posted_by', 'title', 'company', 'type', 'location', 'description', 'apply_url', 'domain',
    ];

    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}
