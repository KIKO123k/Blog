<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    protected $fillable = ['user_id', 'icon', 'color', 'title', 'body', 'url', 'read_at'];

    protected $casts = ['read_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper pour créer une notification (ignore si destinataire = expéditeur).
     */
    public static function send(int $userId, string $title, array $opts = []): void
    {
        static::create([
            'user_id' => $userId,
            'title'   => $title,
            'body'    => $opts['body']  ?? null,
            'url'     => $opts['url']   ?? null,
            'icon'    => $opts['icon']  ?? 'bell',
            'color'   => $opts['color'] ?? '#6366f1',
        ]);
    }
}
