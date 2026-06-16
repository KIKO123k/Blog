<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use Illuminate\Http\Request;

/**
 * Tableau de bord personnel de l'étudiant connecté.
 */
class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $stats = [
            'posts'       => $user->posts()->count(),
            'projects'    => $user->projects()->count(),
            'internships' => $user->internships()->count(),
            'friends'     => Friendship::where('status', 'accepted')
                ->where(fn ($q) => $q->where('requester_id', $user->id)->orWhere('receiver_id', $user->id))
                ->count(),
        ];

        $clubs = $user->clubs()->get();

        $myEvents = $user->eventRegistrations()
            ->where('starts_at', '>=', now()->startOfDay())
            ->orderBy('starts_at')->with('club')->get();

        $recentPosts = $user->posts()->latest()->limit(5)->get();
        $notifications = $user->appNotifications()->limit(5)->get();

        return view('dashboard.index', compact('user', 'stats', 'clubs', 'myEvents', 'recentPosts', 'notifications'));
    }
}
