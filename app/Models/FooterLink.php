<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    use HasFactory;

    protected $table = 'footer_links';

    protected $fillable = [
        'title',
        'url',
        'order',
    ];

    public $timestamps = true;

    // Optional: define a scope for ordering
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}
