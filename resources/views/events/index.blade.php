@extends('layouts.app')
@section('title', 'Agenda des événements – ENSA Kénitra')

@php
    $typeMeta = [
        'atelier'    => ['Atelier',     '#6366f1'],
        'competition'=> ['Compétition', '#dc2626'],
        'conference' => ['Conférence',  '#0ea5e9'],
        'social'     => ['Social',      '#059669'],
    ];
@endphp

@section('content')
<div class="evt-page">

    <div class="evt-header">
        <span class="evt-eyebrow">Vie associative</span>
        <h1 class="evt-title">Agenda des <span class="gradient-title">événements</span></h1>
        <p class="evt-subtitle">Ateliers, compétitions, conférences et activités des clubs de l'ENSA Kénitra. Inscrivez-vous en un clic !</p>
    </div>

    <h2 class="evt-section-title">À venir</h2>
    @if($upcoming->isEmpty())
    <div class="evt-empty"><p>Aucun événement à venir pour le moment. Revenez bientôt !</p></div>
    @else
    <div class="evt-list">
        @foreach($upcoming as $event)
        @php [$tLabel, $tColor] = $typeMeta[$event->type] ?? ['Événement', '#6366f1']; $registered = in_array($event->id, $myEventIds); @endphp
        <div class="evt-card">
            <div class="evt-date" style="--c: {{ $tColor }};">
                <span class="evt-date-day">{{ $event->starts_at->format('d') }}</span>
                <span class="evt-date-mon">{{ ucfirst($event->starts_at->translatedFormat('M')) }}</span>
            </div>
            <div class="evt-body">
                <div class="evt-card-top">
                    <span class="evt-type" style="background: {{ $tColor }}1a; color: {{ $tColor }};">{{ $tLabel }}</span>
                    <a href="{{ route('clubs.show', $event->club) }}" class="evt-club">{{ $event->club->acronym }}</a>
                </div>
                <h3 class="evt-name">{{ $event->title }}</h3>
                @if($event->description)<p class="evt-desc">{{ \Illuminate\Support\Str::limit($event->description, 120) }}</p>@endif
                <div class="evt-meta">
                    <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>{{ $event->starts_at->format('H:i') }}</span>
                    @if($event->location)<span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>{{ $event->location }}</span>@endif
                    <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>{{ $event->participants_count }} inscrit(s)</span>
                </div>
            </div>
            <div class="evt-action">
                @auth
                <form method="POST" action="{{ route('events.rsvp', $event) }}">
                    @csrf
                    <button type="submit" class="evt-rsvp {{ $registered ? 'registered' : '' }}">
                        @if($registered)
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        Inscrit
                        @else
                        S'inscrire
                        @endif
                    </button>
                </form>
                @else
                <a href="{{ route('login') }}" class="evt-rsvp">Se connecter</a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
    @endif

    @if($past->isNotEmpty())
    <h2 class="evt-section-title evt-past-title">Événements passés</h2>
    <div class="evt-past-list">
        @foreach($past as $event)
        @php [$tLabel, $tColor] = $typeMeta[$event->type] ?? ['Événement', '#6366f1']; @endphp
        <div class="evt-past-item">
            <span class="evt-past-date">{{ $event->starts_at->format('d/m/Y') }}</span>
            <span class="evt-past-name">{{ $event->title }}</span>
            <span class="evt-past-club">{{ $event->club->acronym }}</span>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
.evt-page { max-width: 920px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.evt-header { text-align: center; margin-bottom: 2.25rem; }
.evt-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--success, #059669); }
.evt-title { font-size: 2.1rem; font-weight: 900; letter-spacing: -.04em; margin: .3rem 0 .4rem; color: var(--text-primary); }
.evt-subtitle { font-size: .92rem; color: var(--text-muted); max-width: 560px; margin: 0 auto; }
.evt-section-title { font-size: 1.2rem; font-weight: 800; color: var(--text-primary); margin: 0 0 1.1rem; }
.evt-past-title { margin-top: 2.5rem; }

.evt-list { display: flex; flex-direction: column; gap: 1rem; }
.evt-card { display: flex; align-items: stretch; gap: 1rem; background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 18px; padding: 1.1rem; transition: transform .2s, box-shadow .2s; }
.evt-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
.evt-date { flex-shrink: 0; width: 64px; border-radius: 14px; background: var(--c, #6366f1)1a; color: var(--c, #6366f1); display: flex; flex-direction: column; align-items: center; justify-content: center; padding: .5rem; }
.evt-date-day { font-size: 1.6rem; font-weight: 900; line-height: 1; }
.evt-date-mon { font-size: .72rem; font-weight: 700; text-transform: uppercase; }
.evt-body { flex: 1; min-width: 0; }
.evt-card-top { display: flex; align-items: center; gap: 8px; margin-bottom: 5px; }
.evt-type { font-size: .68rem; font-weight: 800; text-transform: uppercase; letter-spacing: .03em; padding: 3px 10px; border-radius: 999px; }
.evt-club { font-size: .72rem; font-weight: 700; color: var(--text-muted); background: rgba(15,23,42,.06); padding: 2px 9px; border-radius: 6px; text-decoration: none; }
.evt-name { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin: 0 0 4px; }
.evt-desc { font-size: .84rem; color: var(--text-muted); line-height: 1.5; margin: 0 0 .6rem; }
.evt-meta { display: flex; flex-wrap: wrap; gap: 1rem; }
.evt-meta span { display: inline-flex; align-items: center; gap: 5px; font-size: .78rem; color: var(--text-muted); font-weight: 600; }
.evt-action { display: flex; align-items: center; flex-shrink: 0; }
.evt-rsvp { display: inline-flex; align-items: center; gap: 6px; padding: 9px 18px; border-radius: 10px; font-size: .82rem; font-weight: 700; cursor: pointer; border: none; background: var(--gradient-primary); color: #0f172a; text-decoration: none; transition: opacity .2s; font-family: inherit; }
.evt-rsvp:hover { opacity: .88; }
.evt-rsvp.registered { background: rgba(16,185,129,.12); color: #059669; border: 1px solid rgba(16,185,129,.3); }

.evt-empty { text-align: center; padding: 2.5rem; color: var(--text-muted); background: rgba(255,255,255,.5); border: 1.5px dashed var(--border-color); border-radius: 16px; }
.evt-past-list { display: flex; flex-direction: column; gap: .5rem; }
.evt-past-item { display: flex; align-items: center; gap: 1rem; padding: .7rem 1rem; background: rgba(255,255,255,.55); border: 1px solid var(--border-color); border-radius: 12px; opacity: .75; }
.evt-past-date { font-size: .78rem; font-weight: 700; color: var(--text-muted); white-space: nowrap; }
.evt-past-name { font-size: .85rem; font-weight: 600; color: var(--text-primary); flex: 1; }
.evt-past-club { font-size: .72rem; font-weight: 700; color: var(--text-muted); background: rgba(15,23,42,.06); padding: 2px 9px; border-radius: 6px; }

@media (max-width: 640px) {
    .evt-card { flex-wrap: wrap; }
    .evt-action { width: 100%; }
    .evt-rsvp { width: 100%; justify-content: center; }
}
</style>
@endsection
