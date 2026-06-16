@extends('layouts.app')
@section('title', 'Partager un article')

@section('content')
<div class="shr-page">
    <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="shr-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Retour à l'article
    </a>

    <h1 class="shr-title">Partager à un ami</h1>

    {{-- Aperçu de l'article --}}
    <div class="shr-preview">
        <span class="shr-preview-ic">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20l9-5-9-5-9 5 9 5z"/><polyline points="12 12 21 7 12 2 3 7 12 12"/></svg>
        </span>
        <div>
            <span class="shr-preview-label">Article</span>
            <span class="shr-preview-title">{{ $post->title }}</span>
        </div>
    </div>

    @if($friends->isEmpty())
    <div class="shr-empty">
        <p>Vous n'avez pas encore d'amis à qui partager. Ajoutez des amis depuis leurs portfolios !</p>
        <a href="{{ route('friends.requests') }}" class="shr-empty-link">Voir mon réseau →</a>
    </div>
    @else
    <form method="POST" action="{{ route('posts.share', $post->slug ?? $post->id) }}" class="shr-form">
        @csrf
        <label class="shr-section-label">Choisir un ami</label>
        <div class="shr-friends">
            @foreach($friends as $i => $friend)
            @php $w = preg_split('/\s+/', trim($friend->name)); $ini = strtoupper(mb_substr($w[0],0,1).(isset($w[1])?mb_substr($w[1],0,1):'')); @endphp
            <label class="shr-friend">
                <input type="radio" name="friend_id" value="{{ $friend->id }}" {{ $i === 0 ? 'checked' : '' }}>
                <span class="shr-friend-inner">
                    <span class="shr-friend-avatar">{{ $ini }}</span>
                    <span class="shr-friend-info">
                        <span class="shr-friend-name">{{ $friend->name }}</span>
                        <span class="shr-friend-sub">{{ $friend->filiere ?? 'Étudiant ENSA' }}</span>
                    </span>
                    <span class="shr-friend-check"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                </span>
            </label>
            @endforeach
        </div>

        <label class="shr-section-label">Ajouter un message (optionnel)</label>
        <textarea name="body" rows="2" class="shr-textarea" placeholder="Regarde cet article, ça peut t'intéresser…"></textarea>

        <button type="submit" class="shr-send">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Envoyer l'article
        </button>
    </form>
    @endif
</div>

<style>
.shr-page { max-width: 600px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.shr-back { display: inline-flex; align-items: center; gap: 6px; font-size: .85rem; font-weight: 700; color: var(--text-muted); text-decoration: none; margin-bottom: 1rem; }
.shr-back:hover { color: var(--text-primary); }
.shr-title { font-size: 1.6rem; font-weight: 900; color: var(--text-primary); margin-bottom: 1.25rem; }

.shr-preview { display: flex; align-items: center; gap: 12px; background: rgba(16,185,129,.07); border: 1px solid rgba(16,185,129,.25); border-radius: 14px; padding: 1rem 1.1rem; margin-bottom: 1.75rem; }
.shr-preview-ic { width: 44px; height: 44px; border-radius: 11px; background: rgba(16,185,129,.15); color: #059669; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.shr-preview > div { display: flex; flex-direction: column; }
.shr-preview-label { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .05em; color: #059669; }
.shr-preview-title { font-size: .98rem; font-weight: 700; color: var(--text-primary); }

.shr-section-label { display: block; font-size: .8rem; font-weight: 700; text-transform: uppercase; letter-spacing: .04em; color: var(--text-muted); margin-bottom: .6rem; }
.shr-friends { display: flex; flex-direction: column; gap: .5rem; margin-bottom: 1.5rem; max-height: 320px; overflow-y: auto; }
.shr-friend { cursor: pointer; }
.shr-friend input { position: absolute; opacity: 0; }
.shr-friend-inner { display: flex; align-items: center; gap: 11px; padding: .7rem .9rem; border: 1.5px solid var(--border-color); border-radius: 12px; transition: border-color .18s, background .18s; }
.shr-friend:hover .shr-friend-inner { border-color: rgba(110,231,183,.5); }
.shr-friend input:checked + .shr-friend-inner { border-color: #34d399; background: rgba(110,231,183,.08); }
.shr-friend-avatar { width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .85rem; color: #fff; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.shr-friend-info { display: flex; flex-direction: column; flex: 1; min-width: 0; }
.shr-friend-name { font-size: .9rem; font-weight: 700; color: var(--text-primary); }
.shr-friend-sub { font-size: .76rem; color: var(--text-muted); }
.shr-friend-check { width: 22px; height: 22px; border-radius: 50%; background: var(--gradient-primary); color: #0f172a; display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity .18s; flex-shrink: 0; }
.shr-friend input:checked + .shr-friend-inner .shr-friend-check { opacity: 1; }

.shr-textarea { width: 100%; box-sizing: border-box; border: 1.5px solid var(--border-color); border-radius: 12px; padding: 11px 14px; font-size: .9rem; font-family: inherit; resize: vertical; outline: none; margin-bottom: 1.25rem; }
.shr-textarea:focus { border-color: #6EE7B7; }
.shr-send { display: inline-flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 12px; font-weight: 800; font-size: .9rem; cursor: pointer; font-family: inherit; }
.shr-send:hover { opacity: .9; }

.shr-empty { text-align: center; padding: 2.5rem; background: rgba(255,255,255,.6); border: 1.5px dashed var(--border-color); border-radius: 16px; color: var(--text-muted); }
.shr-empty-link { display: inline-block; margin-top: .75rem; font-weight: 700; color: var(--success, #059669); text-decoration: none; }
</style>
@endsection
