@extends('layouts.app')
@section('title', 'Demandes d\'amis & Réseau')

@section('content')
<div class="fr-page">

    <div class="fr-header">
        <h1 class="fr-title">Mon Réseau</h1>
        <p class="fr-subtitle">Gérez vos demandes d'amis et restez connecté avec vos camarades.</p>
    </div>

    @if(session('success'))
    <div class="fr-alert">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="fr-grid">

        {{-- PENDING REQUESTS --}}
        <div class="fr-card">
            <div class="fr-card-header">
                <div class="fr-card-icon" style="background:rgba(239,68,68,.1);color:#dc2626">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                </div>
                <h2 class="fr-card-title">Demandes reçues</h2>
                @if($pending->isNotEmpty())
                <span class="fr-badge-count">{{ $pending->count() }}</span>
                @endif
            </div>

            @if($pending->isEmpty())
            <div class="fr-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                <p>Aucune demande en attente.</p>
            </div>
            @else
            <div class="fr-list">
                @foreach($pending as $friendship)
                @php $person = $friendship->requester; @endphp
                <div class="fr-person-row">
                    <a href="{{ route('portfolio.show', $person) }}" class="fr-person-avatar">
                        @if($person->avatar_path)
                            <img src="{{ Storage::url($person->avatar_path) }}" alt="{{ $person->name }}">
                        @else
                            <div class="fr-avatar-initials">{{ strtoupper(substr($person->name,0,2)) }}</div>
                        @endif
                    </a>
                    <div class="fr-person-info">
                        <a href="{{ route('portfolio.show', $person) }}" class="fr-person-name">{{ $person->name }}</a>
                        @php
                            $metaParts = array_filter([$person->filiere, $person->promotion ? 'Promo '.$person->promotion : null]);
                            $meta = $metaParts ? implode(' · ', $metaParts) : 'Étudiant ENSA';
                        @endphp
                        <span class="fr-person-meta">{{ $meta }}</span>
                        <span class="fr-person-time">{{ $friendship->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="fr-actions">
                        <form action="{{ route('friends.accept', $person) }}" method="POST">
                            @csrf
                            <button type="submit" class="fr-btn fr-btn-accept">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Accepter
                            </button>
                        </form>
                        <form action="{{ route('friends.reject', $person) }}" method="POST">
                            @csrf
                            <button type="submit" class="fr-btn fr-btn-reject">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Refuser
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- FRIENDS LIST --}}
        <div class="fr-card">
            <div class="fr-card-header">
                <div class="fr-card-icon" style="background:rgba(110,231,183,.12);color:#059669">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h2 class="fr-card-title">Mes amis</h2>
                @if($friends->isNotEmpty())
                <span class="fr-badge-count fr-badge-green">{{ $friends->count() }}</span>
                @endif
            </div>

            @if($friends->isEmpty())
            <div class="fr-empty">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <p>Vous n'avez pas encore d'amis.<br>Explorez les portfolios de vos camarades !</p>
            </div>
            @else
            <div class="fr-list">
                @foreach($friends as $friend)
                <div class="fr-person-row">
                    <a href="{{ route('portfolio.show', $friend) }}" class="fr-person-avatar">
                        @if($friend->avatar_path)
                            <img src="{{ Storage::url($friend->avatar_path) }}" alt="{{ $friend->name }}">
                        @else
                            <div class="fr-avatar-initials" style="background:linear-gradient(135deg,#6EE7B7,#34d399)">{{ strtoupper(substr($friend->name,0,2)) }}</div>
                        @endif
                    </a>
                    <div class="fr-person-info">
                        <a href="{{ route('portfolio.show', $friend) }}" class="fr-person-name">{{ $friend->name }}</a>
                        @php
                            $fMetaParts = array_filter([$friend->filiere, $friend->promotion ? 'Promo '.$friend->promotion : null]);
                            $fMeta = $fMetaParts ? implode(' · ', $fMetaParts) : 'Étudiant ENSA';
                        @endphp
                        <span class="fr-person-meta">{{ $fMeta }}</span>
                        <span class="fr-friend-badge">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                            Ami
                        </span>
                    </div>
                    <div class="fr-actions">
                        <a href="{{ route('portfolio.show', $friend) }}" class="fr-btn fr-btn-view">Voir profil</a>
                        <form action="{{ route('friends.unfriend', $friend) }}" method="POST" onsubmit="return confirm('Retirer {{ $friend->name }} de vos amis ?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="fr-btn fr-btn-unfriend">Retirer</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>

<style>
.fr-page { max-width: 1000px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.fr-header { margin-bottom: 2rem; }
.fr-title { font-size: 1.8rem; font-weight: 900; color: var(--text-primary); letter-spacing: -.04em; margin: 0 0 .35rem; }
.fr-subtitle { font-size: .9rem; color: var(--text-muted); margin: 0; }

.fr-alert { display: flex; align-items: center; gap: 10px; padding: .9rem 1.2rem; background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.2); border-radius: 12px; margin-bottom: 1.5rem; font-size: .88rem; font-weight: 600; }

.fr-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
@media(max-width: 700px) { .fr-grid { grid-template-columns: 1fr; } }

.fr-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 20px; padding: 1.5rem; }
.fr-card-header { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.25rem; }
.fr-card-icon { width: 38px; height: 38px; border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.fr-card-title { font-size: 1rem; font-weight: 800; color: var(--text-primary); flex: 1; }
.fr-badge-count { background: #dc2626; color: white; border-radius: 999px; min-width: 22px; height: 22px; display: flex; align-items: center; justify-content: center; font-size: .72rem; font-weight: 800; padding: 0 6px; }
.fr-badge-green { background: #059669; }

.fr-empty { display: flex; flex-direction: column; align-items: center; gap: .75rem; padding: 2.5rem 1rem; text-align: center; }
.fr-empty p { font-size: .88rem; color: var(--text-muted); margin: 0; line-height: 1.6; }

.fr-list { display: flex; flex-direction: column; gap: .75rem; }
.fr-person-row { display: flex; align-items: center; gap: .9rem; padding: .85rem; background: rgba(255,255,255,.6); border: 1px solid var(--border-color); border-radius: 14px; transition: background .18s; }
.fr-person-row:hover { background: rgba(255,255,255,.9); }

.fr-person-avatar { width: 46px; height: 46px; border-radius: 50%; overflow: hidden; flex-shrink: 0; text-decoration: none; display: block; }
.fr-person-avatar img { width: 100%; height: 100%; object-fit: cover; }
.fr-avatar-initials { width: 46px; height: 46px; border-radius: 50%; background: linear-gradient(135deg, #a78bfa, #7c3aed); display: flex; align-items: center; justify-content: center; font-size: .9rem; font-weight: 800; color: white; }

.fr-person-info { flex: 1; min-width: 0; display: flex; flex-direction: column; gap: 2px; }
.fr-person-name { font-size: .9rem; font-weight: 700; color: var(--text-primary); text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.fr-person-name:hover { color: var(--success); }
.fr-person-meta { font-size: .75rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.fr-person-time { font-size: .72rem; color: var(--text-muted); opacity: .7; }
.fr-friend-badge { display: inline-flex; align-items: center; gap: 4px; font-size: .7rem; font-weight: 700; color: #059669; background: rgba(16,185,129,.1); padding: 2px 8px; border-radius: 999px; width: fit-content; }

.fr-actions { display: flex; flex-direction: column; gap: .4rem; flex-shrink: 0; }
.fr-btn { display: inline-flex; align-items: center; gap: 5px; padding: 6px 12px; border-radius: 9px; font-size: .75rem; font-weight: 700; cursor: pointer; border: none; font-family: inherit; text-decoration: none; text-align: center; justify-content: center; transition: opacity .18s, transform .18s; white-space: nowrap; }
.fr-btn:hover { opacity: .85; transform: translateY(-1px); }
.fr-btn-accept  { background: linear-gradient(135deg,#6EE7B7,#34d399); color: #0f172a; }
.fr-btn-reject  { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.2); }
.fr-btn-view    { background: rgba(15,23,42,.07); color: var(--text-primary); }
.fr-btn-unfriend { background: rgba(239,68,68,.08); color: #dc2626; border: 1px solid rgba(239,68,68,.15); font-size: .72rem; padding: 5px 10px; }
</style>
@endsection
