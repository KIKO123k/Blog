<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /** Agenda global de tous les événements à venir (+ passés récents). */
    public function index()
    {
        $upcoming = Event::with('club')->withCount('participants')
            ->upcoming()->orderBy('starts_at')->get();

        $past = Event::with('club')->withCount('participants')
            ->where('starts_at', '<', now()->startOfDay())
            ->orderByDesc('starts_at')->limit(6)->get();

        $myEventIds = auth()->check()
            ? auth()->user()->eventRegistrations()->pluck('events.id')->all()
            : [];

        return view('events.index', compact('upcoming', 'past', 'myEventIds'));
    }

    /** Inscription / désinscription à un événement (toggle). */
    public function toggleRsvp(Request $request, Event $event)
    {
        $user = $request->user();
        $already = $event->participants()->where('user_id', $user->id)->exists();

        if ($already) {
            $event->participants()->detach($user->id);
            $msg = 'Vous vous êtes désinscrit(e) de « ' . $event->title . ' ».';
        } else {
            $event->participants()->attach($user->id);
            $msg = 'Inscription confirmée à « ' . $event->title . ' » !';
        }

        return back()->with('success', $msg);
    }
}
