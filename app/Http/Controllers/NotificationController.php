<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = $request->user()->appNotifications()->paginate(20);

        // Marquer tout comme lu à l'ouverture
        UserNotification::where('user_id', $request->user()->id)
            ->whereNull('read_at')->update(['read_at' => now()]);

        return view('notifications.index', compact('notifications'));
    }

    public function open(Request $request, UserNotification $notification)
    {
        abort_unless($notification->user_id === $request->user()->id, 403);
        $notification->update(['read_at' => now()]);

        return redirect($notification->url ?: route('notifications.index'));
    }
}
