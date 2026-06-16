<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'user_id','company','position','period',
        'description','report_path','year','type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
