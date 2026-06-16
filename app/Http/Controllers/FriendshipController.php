<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendshipController extends Controller
{
    public function send(User $user)
    {
        abort_if(Auth::id() === $user->id, 403);

        $existing = Auth::user()->friendshipWith($user->id);
        if (!$existing) {
            Friendship::create([
                'requester_id' => Auth::id(),
                'receiver_id'  => $user->id,
                'status'       => 'pending',
            ]);

            UserNotification::send($user->id, Auth::user()->name . ' souhaite vous ajouter', [
                'body'  => 'Vous avez reçu une nouvelle demande d\'ami.',
                'url'   => route('friends.requests'),
                'icon'  => 'friend',
                'color' => '#6366f1',
            ]);
        }

        return back()->with('success', 'Demande d\'ami envoyée à ' . $user->name . ' !');
    }

    public function cancel(User $user)
    {
        Friendship::where('requester_id', Auth::id())
            ->where('receiver_id', $user->id)
            ->where('status', 'pending')
            ->delete();

        return back()->with('success', 'Demande annulée.');
    }

    public function accept(User $user)
    {
        Friendship::where('requester_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->update(['status' => 'accepted']);

        UserNotification::send($user->id, Auth::user()->name . ' a accepté votre demande', [
            'body'  => 'Vous êtes maintenant amis 🎉',
            'url'   => route('portfolio.show', Auth::id()),
            'icon'  => 'friend',
            'color' => '#059669',
        ]);

        return back()->with('success', 'Vous êtes maintenant amis avec ' . $user->name . ' !');
    }

    public function reject(User $user)
    {
        Friendship::where('requester_id', $user->id)
            ->where('receiver_id', Auth::id())
            ->where('status', 'pending')
            ->delete();

        return back()->with('success', 'Demande refusée.');
    }

    public function unfriend(User $user)
    {
        Friendship::where('status', 'accepted')
            ->where(function ($q) use ($user) {
                $q->where('requester_id', Auth::id())->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($user) {
                $q->where('status', 'accepted')
                  ->where('requester_id', $user->id)->where('receiver_id', Auth::id());
            })->delete();

        return back()->with('success', 'Retiré de vos amis.');
    }

    public function requests()
    {
        $pending = Auth::user()
            ->receivedFriendRequests()
            ->with('requester')
            ->where('status', 'pending')
            ->latest()
            ->get();

        $friends = Friendship::where('status', 'accepted')
            ->where(function ($q) {
                $q->where('requester_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
            })
            ->with(['requester', 'receiver'])
            ->latest()
            ->get()
            ->map(fn($f) => $f->requester_id === Auth::id() ? $f->receiver : $f->requester);

        return view('friends.requests', compact('pending', 'friends'));
    }
}
