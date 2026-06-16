<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Post;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /** Boîte de réception : liste des conversations. */
    public function index()
    {
        return view('messages.index', [
            'conversations' => $this->conversations(),
            'active'        => null,
        ]);
    }

    /** Fil d'une conversation avec un utilisateur. */
    public function show(User $user)
    {
        $me = auth()->id();
        abort_if($user->id === $me, 404);

        // Marquer comme lus les messages reçus de cet utilisateur
        Message::where('sender_id', $user->id)->where('receiver_id', $me)
            ->whereNull('read_at')->update(['read_at' => now()]);

        $messages = Message::between($me, $user->id)->with('sharedPost')->orderBy('created_at')->get();

        return view('messages.index', [
            'conversations' => $this->conversations(),
            'active'        => $user,
            'messages'      => $messages,
        ]);
    }

    /** Envoyer un message (texte, pièce jointe image/PDF, ou article partagé). */
    public function store(Request $request, User $user)
    {
        abort_if($user->id === auth()->id(), 404);

        $request->validate([
            'body'           => 'nullable|string|max:2000',
            'attachment'     => 'nullable|file|mimes:jpg,jpeg,png,webp,gif,pdf|max:8192',
            'shared_post_id' => 'nullable|exists:posts,id',
        ]);

        $data = [
            'sender_id'      => auth()->id(),
            'receiver_id'    => $user->id,
            'body'           => $request->body,
            'shared_post_id' => $request->shared_post_id,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $ext = strtolower($file->getClientOriginalExtension());
            $data['attachment_path'] = $file->store('messages', 'public');
            $data['attachment_type'] = $ext === 'pdf' ? 'pdf' : 'image';
            $data['attachment_name'] = $file->getClientOriginalName();
        }

        // Au moins un contenu requis
        if (blank($data['body']) && empty($data['attachment_path']) && empty($data['shared_post_id'])) {
            return back()->withErrors(['body' => 'Votre message est vide.']);
        }

        Message::create($data);

        $preview = $request->shared_post_id ? 'a partagé un article 📄'
            : (!empty($data['attachment_path']) ? 'a envoyé une pièce jointe 📎'
            : \Illuminate\Support\Str::limit($data['body'], 60));

        UserNotification::send($user->id, 'Nouveau message de ' . auth()->user()->name, [
            'body'  => $preview,
            'url'   => route('messages.show', auth()->id()),
            'icon'  => 'message',
            'color' => '#0ea5e9',
        ]);

        return redirect()->route('messages.show', $user);
    }

    /** Formulaire : choisir un ami à qui partager un article. */
    public function shareForm(Post $post)
    {
        $friends = auth()->user()->friends();
        return view('messages.share', compact('post', 'friends'));
    }

    /** Envoie un article à un ami via un message. */
    public function sharePost(Request $request, Post $post)
    {
        $request->validate([
            'friend_id' => 'required|exists:users,id',
            'body'      => 'nullable|string|max:1000',
        ]);

        $friend = User::findOrFail($request->friend_id);
        abort_if($friend->id === auth()->id(), 403);

        Message::create([
            'sender_id'      => auth()->id(),
            'receiver_id'    => $friend->id,
            'body'           => $request->body,
            'shared_post_id' => $post->id,
        ]);

        UserNotification::send($friend->id, auth()->user()->name . ' a partagé un article', [
            'body'  => \Illuminate\Support\Str::limit($post->title, 60),
            'url'   => route('messages.show', auth()->id()),
            'icon'  => 'message',
            'color' => '#0ea5e9',
        ]);

        return redirect()->route('messages.show', $friend)
            ->with('success', 'Article partagé à ' . $friend->name . ' !');
    }

    /** Construit la liste des conversations (dernier message + non-lus par interlocuteur). */
    private function conversations()
    {
        $me = auth()->id();

        $all = Message::where('sender_id', $me)->orWhere('receiver_id', $me)
            ->orderByDesc('created_at')->get();

        $partnerIds = $all->map(fn ($m) => $m->sender_id === $me ? $m->receiver_id : $m->sender_id)
            ->unique()->values();

        $users = User::whereIn('id', $partnerIds)->get()->keyBy('id');

        return $partnerIds->map(function ($pid) use ($all, $users, $me) {
            $last = $all->first(fn ($m) => $m->sender_id === $pid || $m->receiver_id === $pid);
            $unread = $all->where('sender_id', $pid)->where('receiver_id', $me)->whereNull('read_at')->count();
            return (object) [
                'user'   => $users[$pid] ?? null,
                'last'   => $last,
                'unread' => $unread,
            ];
        })->filter(fn ($c) => $c->user !== null)->values();
    }
}
