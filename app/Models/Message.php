<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id', 'receiver_id', 'body', 'read_at',
        'attachment_path', 'attachment_type', 'attachment_name', 'shared_post_id',
    ];

    protected $casts = ['read_at' => 'datetime'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    /** Article partagé dans ce message (le cas échéant). */
    public function sharedPost()
    {
        return $this->belongsTo(Post::class, 'shared_post_id');
    }

    /** Messages échangés entre deux utilisateurs (dans les deux sens). */
    public function scopeBetween($query, int $a, int $b)
    {
        return $query->where(function ($q) use ($a, $b) {
            $q->where('sender_id', $a)->where('receiver_id', $b);
        })->orWhere(function ($q) use ($a, $b) {
            $q->where('sender_id', $b)->where('receiver_id', $a);
        });
    }
}
