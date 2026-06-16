@extends('layouts.app')
@section('title', 'Mon tableau de bord')

@section('content')
<div class="dsh-page">

    <div class="dsh-head">
        <div>
            <h1>Bonjour, <span class="gradient-title">{{ explode(' ', $user->name)[0] }}</span> 👋</h1>
            <p>Voici un aperçu de votre activité sur EduBlog.</p>
        </div>
        <a href="{{ route('portfolio.show', $user) }}" class="dsh-profile-btn">Voir mon portfolio →</a>
    </div>

    {{-- Stats --}}
    <div class="dsh-stats">
        <a href="{{ route('my-articles') }}" class="dsh-stat">
            <span class="dsh-stat-icon" style="background:rgba(16,185,129,.12);color:#059669"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20l9-5-9-5-9 5 9 5z"/><polyline points="12 12 21 7 12 2 3 7 12 12"/></svg></span>
            <span class="dsh-stat-num">{{ $stats['posts'] }}</span>
            <span class="dsh-stat-label">Articles</span>
        </a>
        <a href="{{ route('portfolio.edit') }}" class="dsh-stat">
            <span class="dsh-stat-icon" style="background:rgba(99,102,241,.12);color:#6366f1"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h1v6H9zM14 9h1v6h-1z"/></svg></span>
            <span class="dsh-stat-num">{{ $stats['projects'] }}</span>
            <span class="dsh-stat-label">Projets</span>
        </a>
        <a href="{{ route('portfolio.edit') }}" class="dsh-stat">
            <span class="dsh-stat-icon" style="background:rgba(245,158,11,.12);color:#d97706"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg></span>
            <span class="dsh-stat-num">{{ $stats['internships'] }}</span>
            <span class="dsh-stat-label">Stages</span>
        </a>
        <a href="{{ route('friends.requests') }}" class="dsh-stat">
            <span class="dsh-stat-icon" style="background:rgba(59,130,246,.12);color:#2563eb"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg></span>
            <span class="dsh-stat-num">{{ $stats['friends'] }}</span>
            <span class="dsh-stat-label">Amis</span>
        </a>
    </div>

    <div class="dsh-grid">
        <div class="dsh-col">
            {{-- Mes clubs --}}
            <div class="dsh-card">
                <div class="dsh-card-head"><h2>Mes clubs</h2></div>
                @if($clubs->isEmpty())
                <p class="dsh-empty-text">Vous n'êtes membre d'aucun club. <a href="{{ route('clubs.index') }}">Découvrir les clubs →</a></p>
                @else
                <div class="dsh-club-list">
                    @foreach($clubs as $c)
                    <a href="{{ route('clubs.show', $c) }}" class="dsh-club">
                        <span class="dsh-club-acr">{{ $c->acronym }}</span>
                        <span class="dsh-club-info">
                            <span class="dsh-club-name">{{ $c->name }}</span>
                            <span class="dsh-club-role">{{ $c->pivot->role ?? 'Adhérent(e)' }}</span>
                        </span>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Mes articles récents --}}
            <div class="dsh-card">
                <div class="dsh-card-head"><h2>Mes articles récents</h2><a href="{{ route('my-articles') }}" class="dsh-see-all">Tous →</a></div>
                @if($recentPosts->isEmpty())
                <p class="dsh-empty-text">Aucun article publié. <a href="{{ route('posts.create') }}">Écrire un article →</a></p>
                @else
                <div class="dsh-list">
                    @foreach($recentPosts as $p)
                    <a href="{{ route('posts.show', $p->slug ?? $p->id) }}" class="dsh-list-item">
                        <span>{{ $p->title }}</span>
                        <span class="dsh-list-date">{{ $p->created_at->format('d M Y') }}</span>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

        <div class="dsh-col">
            {{-- Mes événements --}}
            <div class="dsh-card">
                <div class="dsh-card-head"><h2>Mes événements</h2><a href="{{ route('events.index') }}" class="dsh-see-all">Agenda →</a></div>
                @if($myEvents->isEmpty())
                <p class="dsh-empty-text">Aucune inscription. <a href="{{ route('events.index') }}">Voir l'agenda →</a></p>
                @else
                <div class="dsh-list">
                    @foreach($myEvents as $e)
                    <div class="dsh-event">
                        <span class="dsh-event-date">{{ $e->starts_at->format('d/m') }}</span>
                        <span class="dsh-event-info">
                            <span class="dsh-event-name">{{ $e->title }}</span>
                            <span class="dsh-event-club">{{ $e->club->acronym }} · {{ $e->starts_at->format('H:i') }}</span>
                        </span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Activité récente --}}
            <div class="dsh-card">
                <div class="dsh-card-head"><h2>Activité récente</h2><a href="{{ route('notifications.index') }}" class="dsh-see-all">Tout →</a></div>
                @if($notifications->isEmpty())
                <p class="dsh-empty-text">Aucune activité pour le moment.</p>
                @else
                <div class="dsh-list">
                    @foreach($notifications as $n)
                    <a href="{{ route('notifications.open', $n) }}" class="dsh-list-item">
                        <span style="color: {{ $n->color }}">●</span>
                        <span style="flex:1">{{ $n->title }}</span>
                        <span class="dsh-list-date">{{ $n->created_at->diffForHumans(null, true) }}</span>
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.dsh-page { max-width: 1050px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.dsh-head { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.75rem; }
.dsh-head h1 { font-size: 1.9rem; font-weight: 900; letter-spacing: -.03em; color: var(--text-primary); }
.dsh-head p { font-size: .9rem; color: var(--text-muted); margin-top: 2px; }
.dsh-profile-btn { padding: 9px 18px; background: var(--gradient-primary); color: #0f172a; border-radius: 11px; font-weight: 700; font-size: .85rem; text-decoration: none; }

.dsh-stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
@media (max-width: 640px) { .dsh-stats { grid-template-columns: repeat(2, 1fr); } }
.dsh-stat { display: flex; flex-direction: column; align-items: flex-start; gap: 6px; background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 18px; padding: 1.25rem; text-decoration: none; transition: transform .2s, box-shadow .2s; }
.dsh-stat:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
.dsh-stat-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-bottom: 4px; }
.dsh-stat-num { font-size: 1.8rem; font-weight: 900; color: var(--text-primary); line-height: 1; }
.dsh-stat-label { font-size: .8rem; color: var(--text-muted); font-weight: 600; }

.dsh-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; align-items: start; }
@media (max-width: 760px) { .dsh-grid { grid-template-columns: 1fr; } }
.dsh-col { display: flex; flex-direction: column; gap: 1.25rem; }
.dsh-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 18px; padding: 1.3rem; }
.dsh-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1rem; }
.dsh-card-head h2 { font-size: 1.02rem; font-weight: 800; color: var(--text-primary); }
.dsh-see-all { font-size: .8rem; font-weight: 700; color: var(--success, #059669); text-decoration: none; }
.dsh-empty-text { font-size: .85rem; color: var(--text-muted); }
.dsh-empty-text a { color: var(--success, #059669); font-weight: 700; text-decoration: none; }

.dsh-club-list { display: flex; flex-direction: column; gap: .6rem; }
.dsh-club { display: flex; align-items: center; gap: 11px; padding: .6rem .7rem; border: 1px solid var(--border-color); border-radius: 12px; text-decoration: none; transition: border-color .15s; }
.dsh-club:hover { border-color: rgba(110,231,183,.5); }
.dsh-club-acr { font-size: .72rem; font-weight: 800; color: var(--text-muted); background: rgba(15,23,42,.06); padding: 5px 9px; border-radius: 7px; white-space: nowrap; }
.dsh-club-info { display: flex; flex-direction: column; min-width: 0; }
.dsh-club-name { font-size: .86rem; font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dsh-club-role { font-size: .74rem; color: #6366f1; font-weight: 600; }

.dsh-list { display: flex; flex-direction: column; gap: .35rem; }
.dsh-list-item { display: flex; align-items: center; gap: 8px; justify-content: space-between; padding: .55rem .7rem; border-radius: 10px; text-decoration: none; color: var(--text-primary); font-size: .85rem; font-weight: 600; transition: background .15s; }
.dsh-list-item:hover { background: rgba(15,23,42,.04); }
.dsh-list-date { font-size: .73rem; color: var(--text-muted); white-space: nowrap; font-weight: 500; }

.dsh-event { display: flex; align-items: center; gap: 11px; padding: .5rem .6rem; }
.dsh-event-date { width: 44px; height: 40px; flex-shrink: 0; border-radius: 9px; background: rgba(245,158,11,.1); color: #d97706; display: flex; align-items: center; justify-content: center; font-size: .8rem; font-weight: 800; }
.dsh-event-info { display: flex; flex-direction: column; min-width: 0; }
.dsh-event-name { font-size: .85rem; font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.dsh-event-club { font-size: .74rem; color: var(--text-muted); }
</style>
@endsection
