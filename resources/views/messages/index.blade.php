@extends('layouts.app')
@section('title', 'Messagerie')

@php
    if (!function_exists('msgInitials')) {
        function msgInitials($name) {
            $w = preg_split('/\s+/', trim($name));
            return strtoupper(mb_substr($w[0],0,1) . (isset($w[1]) ? mb_substr($w[1],0,1) : ''));
        }
    }
@endphp

@section('content')
<div class="msg-page">
    <div class="msg-shell">

        {{-- Liste des conversations --}}
        <aside class="msg-sidebar {{ isset($active) && $active ? 'has-active' : '' }}">
            <div class="msg-sidebar-head">
                <h2>Messages</h2>
            </div>
            <div class="msg-conv-list">
                @forelse($conversations as $c)
                <a href="{{ route('messages.show', $c->user) }}" class="msg-conv {{ isset($active) && $active && $active->id === $c->user->id ? 'active' : '' }}">
                    <span class="msg-conv-avatar">{{ msgInitials($c->user->name) }}</span>
                    <span class="msg-conv-info">
                        <span class="msg-conv-top">
                            <span class="msg-conv-name">{{ $c->user->name }}</span>
                            <span class="msg-conv-time">{{ $c->last->created_at->diffForHumans(null, true) }}</span>
                        </span>
                        <span class="msg-conv-preview">
                            @if($c->last->sender_id === auth()->id())<span class="msg-you">Vous : </span>@endif
                            {{ \Illuminate\Support\Str::limit($c->last->body, 38) }}
                        </span>
                    </span>
                    @if($c->unread > 0)<span class="msg-unread-dot">{{ $c->unread }}</span>@endif
                </a>
                @empty
                <div class="msg-empty-list">Aucune conversation. Visitez un portfolio et cliquez sur « Message » pour démarrer.</div>
                @endforelse
            </div>
        </aside>

        {{-- Fil de conversation --}}
        <section class="msg-thread {{ isset($active) && $active ? 'has-active' : '' }}">
            @if(isset($active) && $active)
            <div class="msg-thread-head">
                <a href="{{ route('messages.index') }}" class="msg-back-mobile">←</a>
                <a href="{{ route('portfolio.show', $active) }}" class="msg-thread-user">
                    <span class="msg-conv-avatar sm">{{ msgInitials($active->name) }}</span>
                    <span>
                        <span class="msg-thread-name">{{ $active->name }}</span>
                        <span class="msg-thread-sub">{{ $active->filiere ?? 'Étudiant ENSA' }}</span>
                    </span>
                </a>
            </div>

            <div class="msg-messages" id="msgScroll">
                @forelse($messages as $m)
                <div class="msg-bubble-row {{ $m->sender_id === auth()->id() ? 'mine' : 'theirs' }}">
                    <div class="msg-bubble {{ ($m->attachment_type === 'image' || $m->sharedPost) ? 'has-media' : '' }}">

                        {{-- Article partagé --}}
                        @if($m->sharedPost)
                        <a href="{{ route('posts.show', $m->sharedPost->slug ?? $m->sharedPost->id) }}" class="msg-shared-post">
                            <span class="msg-shared-icon">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20l9-5-9-5-9 5 9 5z"/><polyline points="12 12 21 7 12 2 3 7 12 12"/></svg>
                            </span>
                            <span class="msg-shared-text">
                                <span class="msg-shared-label">Article partagé</span>
                                <span class="msg-shared-title">{{ \Illuminate\Support\Str::limit($m->sharedPost->title, 60) }}</span>
                            </span>
                        </a>
                        @endif

                        {{-- Pièce jointe --}}
                        @if($m->attachment_path)
                            @if($m->attachment_type === 'image')
                            <a href="{{ Storage::url($m->attachment_path) }}" target="_blank" class="msg-attach-img">
                                <img src="{{ Storage::url($m->attachment_path) }}" alt="{{ $m->attachment_name }}">
                            </a>
                            @else
                            <a href="{{ Storage::url($m->attachment_path) }}" target="_blank" class="msg-attach-file">
                                <span class="msg-attach-file-ic">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </span>
                                <span class="msg-attach-file-name">{{ \Illuminate\Support\Str::limit($m->attachment_name, 28) }}</span>
                            </a>
                            @endif
                        @endif

                        @if($m->body)<span class="msg-bubble-text">{{ $m->body }}</span>@endif
                        <span class="msg-bubble-time">{{ $m->created_at->format('H:i') }}</span>
                    </div>
                </div>
                @empty
                <div class="msg-thread-empty">
                    <p>Démarrez la conversation avec {{ $active->name }} 👋</p>
                </div>
                @endforelse
            </div>

            <form method="POST" action="{{ route('messages.store', $active) }}" class="msg-composer" enctype="multipart/form-data" id="msgComposer">
                @csrf
                <label class="msg-attach-btn" title="Joindre une photo ou un PDF">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    <input type="file" name="attachment" accept="image/*,application/pdf" class="msg-file-input" id="msgFileInput" onchange="msgFilePicked(this)">
                </label>
                <input type="text" name="body" placeholder="Écrivez un message..." autocomplete="off" maxlength="2000" autofocus>
                <button type="submit" aria-label="Envoyer">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                </button>
            </form>
            <div class="msg-file-chip" id="msgFileChip" style="display:none">
                <span id="msgFileName"></span>
                <button type="button" onclick="msgFileClear()" aria-label="Retirer">✕</button>
            </div>
            @else
            <div class="msg-no-active">
                <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.3" opacity=".25"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                <p>Sélectionnez une conversation pour commencer à discuter.</p>
            </div>
            @endif
        </section>
    </div>
</div>

<style>
.msg-page { max-width: 1100px; margin: 0 auto; padding: 1.5rem 1.5rem 3rem; }
.msg-shell { display: grid; grid-template-columns: 320px 1fr; gap: 1rem; height: 70vh; min-height: 480px; }
.msg-sidebar, .msg-thread { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 20px; overflow: hidden; display: flex; flex-direction: column; }
.msg-sidebar-head { padding: 1.1rem 1.25rem; border-bottom: 1px solid var(--border-color); }
.msg-sidebar-head h2 { font-size: 1.15rem; font-weight: 800; color: var(--text-primary); }

.msg-conv-list { overflow-y: auto; flex: 1; }
.msg-conv { display: flex; align-items: center; gap: 11px; padding: .8rem 1.1rem; text-decoration: none; border-bottom: 1px solid var(--border-color); transition: background .15s; }
.msg-conv:hover { background: rgba(15,23,42,.03); }
.msg-conv.active { background: rgba(110,231,183,.1); }
.msg-conv-avatar { width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .9rem; color: #fff; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.msg-conv-avatar.sm { width: 38px; height: 38px; font-size: .8rem; }
.msg-conv-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
.msg-conv-top { display: flex; justify-content: space-between; align-items: baseline; gap: 6px; }
.msg-conv-name { font-size: .9rem; font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.msg-conv-time { font-size: .68rem; color: var(--text-muted); white-space: nowrap; flex-shrink: 0; }
.msg-conv-preview { font-size: .8rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.msg-you { color: var(--text-muted); }
.msg-unread-dot { flex-shrink: 0; min-width: 20px; height: 20px; padding: 0 6px; border-radius: 999px; background: var(--gradient-primary); color: #0f172a; font-size: .7rem; font-weight: 800; display: flex; align-items: center; justify-content: center; }
.msg-empty-list { padding: 2rem 1.25rem; font-size: .85rem; color: var(--text-muted); text-align: center; }

.msg-thread-head { padding: .9rem 1.25rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 10px; }
.msg-back-mobile { display: none; font-size: 1.3rem; color: var(--text-muted); text-decoration: none; }
.msg-thread-user { display: flex; align-items: center; gap: 10px; text-decoration: none; }
.msg-thread-name { display: block; font-size: .95rem; font-weight: 800; color: var(--text-primary); }
.msg-thread-sub { display: block; font-size: .75rem; color: var(--text-muted); }

.msg-messages { flex: 1; overflow-y: auto; padding: 1.25rem; display: flex; flex-direction: column; gap: .5rem; }
.msg-bubble-row { display: flex; }
.msg-bubble-row.mine { justify-content: flex-end; }
.msg-bubble { max-width: 72%; padding: .6rem .9rem; border-radius: 16px; font-size: .88rem; line-height: 1.5; position: relative; }
.msg-bubble-row.theirs .msg-bubble { background: rgba(15,23,42,.06); color: var(--text-primary); border-bottom-left-radius: 4px; }
.msg-bubble-row.mine .msg-bubble { background: linear-gradient(135deg, #6EE7B7, #34d399); color: #0f172a; border-bottom-right-radius: 4px; }
.msg-bubble-time { display: block; font-size: .62rem; opacity: .6; margin-top: 3px; text-align: right; }
.msg-thread-empty { margin: auto; color: var(--text-muted); font-size: .9rem; }

.msg-composer { display: flex; gap: 8px; padding: .9rem 1rem; border-top: 1px solid var(--border-color); }
.msg-composer input { flex: 1; border: 1px solid var(--border-color); border-radius: 12px; padding: 11px 16px; font-size: .9rem; font-family: inherit; outline: none; background: var(--bg-tertiary, rgba(15,23,42,.03)); color: var(--text-primary); }
.msg-composer input[type=text]:focus { border-color: #6EE7B7; }
.msg-composer button[type=submit] { width: 44px; height: 44px; flex-shrink: 0; border: none; border-radius: 12px; background: var(--gradient-primary); color: #0f172a; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.msg-no-active { margin: auto; text-align: center; color: var(--text-muted); display: flex; flex-direction: column; align-items: center; gap: 1rem; padding: 2rem; }

/* Pièce jointe — bouton & chip */
.msg-attach-btn { width: 44px; height: 44px; flex-shrink: 0; border-radius: 12px; background: var(--bg-tertiary, rgba(15,23,42,.05)); color: var(--text-muted); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background .18s, color .18s; }
.msg-attach-btn:hover { background: rgba(110,231,183,.15); color: #059669; }
.msg-file-input { display: none; }
.msg-file-chip { display: flex; align-items: center; justify-content: space-between; gap: 10px; margin: 0 1rem .8rem; padding: 8px 12px; background: rgba(110,231,183,.1); border: 1px solid rgba(110,231,183,.3); border-radius: 10px; font-size: .82rem; color: #047857; font-weight: 600; }
.msg-file-chip button { background: none; border: none; color: #047857; cursor: pointer; font-size: .9rem; }

/* Pièce jointe — dans la bulle */
.msg-bubble.has-media { padding: .4rem .4rem .5rem; }
.msg-bubble-text { display: block; padding: 0 .5rem; }
.msg-bubble.has-media .msg-bubble-time { padding: 0 .5rem; }
.msg-attach-img { display: block; border-radius: 12px; overflow: hidden; margin-bottom: 4px; }
.msg-attach-img img { display: block; max-width: 240px; max-height: 240px; width: 100%; object-fit: cover; }
.msg-attach-file { display: flex; align-items: center; gap: 9px; padding: 8px 12px; background: rgba(0,0,0,.06); border-radius: 10px; text-decoration: none; color: inherit; margin-bottom: 4px; }
.msg-bubble-row.mine .msg-attach-file { background: rgba(255,255,255,.25); }
.msg-attach-file-ic { flex-shrink: 0; }
.msg-attach-file-name { font-size: .82rem; font-weight: 600; }

/* Article partagé — dans la bulle */
.msg-shared-post { display: flex; align-items: center; gap: 10px; padding: 9px 11px; background: rgba(0,0,0,.06); border-radius: 10px; text-decoration: none; color: inherit; margin-bottom: 4px; }
.msg-bubble-row.mine .msg-shared-post { background: rgba(255,255,255,.25); }
.msg-shared-icon { width: 30px; height: 30px; flex-shrink: 0; border-radius: 8px; background: rgba(16,185,129,.15); color: #059669; display: flex; align-items: center; justify-content: center; }
.msg-bubble-row.mine .msg-shared-icon { background: rgba(15,23,42,.15); color: #0f172a; }
.msg-shared-text { display: flex; flex-direction: column; min-width: 0; }
.msg-shared-label { font-size: .66rem; text-transform: uppercase; letter-spacing: .04em; opacity: .7; font-weight: 700; }
.msg-shared-title { font-size: .85rem; font-weight: 700; }

@media (max-width: 760px) {
    .msg-shell { grid-template-columns: 1fr; }
    .msg-sidebar.has-active { display: none; }
    .msg-thread:not(.has-active) { display: none; }
    .msg-back-mobile { display: inline; }
}
</style>
<script>
    var s = document.getElementById('msgScroll');
    if (s) s.scrollTop = s.scrollHeight;

    function msgFilePicked(input) {
        var chip = document.getElementById('msgFileChip');
        var name = document.getElementById('msgFileName');
        if (input.files && input.files[0]) {
            name.textContent = '📎 ' + input.files[0].name;
            chip.style.display = 'flex';
        }
    }
    function msgFileClear() {
        document.getElementById('msgFileInput').value = '';
        document.getElementById('msgFileChip').style.display = 'none';
    }
</script>
@endsection
