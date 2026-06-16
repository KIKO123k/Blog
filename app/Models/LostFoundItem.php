<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LostFoundItem extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'description',
        'category', 'location', 'item_date', 'image_path', 'status',
    ];

    protected $casts = ['item_date' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
