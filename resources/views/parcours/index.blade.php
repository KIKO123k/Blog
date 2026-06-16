@extends('layouts.app')

@section('title', 'Notre Offre de Formation – ENSA Kénitra')

@section('content')
<section class="hero">
    <h1>Notre <span class="gradient-title">Offre de Formation</span></h1>
    <p class="text-center text-muted mt-4">De la classe préparatoire au doctorat, en passant par l'international — tout l'écosystème de l'ENSA Kénitra.</p>
</section>

@php
    $icons = [
        'book'    => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
        'gear'    => '<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
        'cap'     => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
        'atom'    => '<circle cx="12" cy="12" r="1"/><path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"/><path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"/>',
        'diploma' => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
        'plane'   => '<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>',
    ];
    $countryColors = ['FR' => '#2563eb', 'DE' => '#6366f1', 'BR' => '#16a34a'];
@endphp

{{-- ===== Programs grid — toutes les cartes cliquables ===== --}}
<div class="prc-grid">
    @foreach($programs as $p)
    @php
        $isCycle = $p['slug'] === 'cycle-ingenieur';
        $href    = $isCycle ? route('majors.index') : route('parcours.show', $p['slug']);
        $label   = $isCycle ? 'Voir les 6 filières' : 'En savoir plus';
    @endphp
    <article class="prc-card glass prc-card-clickable">
        <div class="prc-card-head">
            <span class="prc-icon" style="background: {{ $p['color'] }}1a; color: {{ $p['color'] }};">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$p['icon']] ?? $icons['book'] !!}</svg>
            </span>
            <span class="prc-badge" style="background: {{ $p['color'] }}1a; color: {{ $p['color'] }};">{{ $p['badge'] }}</span>
        </div>
        <h3 class="prc-title">{{ $p['title'] }}</h3>
        <p class="prc-subtitle">{{ $p['subtitle'] }}</p>
        <p class="prc-desc">{{ $p['description'] }}</p>
        <ul class="prc-points">
            @foreach($p['points'] as $point)
            <li>
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="{{ $p['color'] }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                {{ $point }}
            </li>
            @endforeach
        </ul>
        <a href="{{ $href }}" class="prc-link prc-link-stretched" style="color: {{ $p['color'] }};">
            {{ $label }}
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </article>
    @endforeach
</div>

{{-- ===== Partner schools ===== --}}
<section class="prc-partners">
    <div class="prc-partners-head">
        <span class="prc-partners-eyebrow">Réseau international</span>
        <h2 class="prc-partners-title">Nos Écoles Partenaires</h2>
        <p class="prc-partners-sub">Universités et grandes écoles partenaires pour la double diplomation, la mobilité et la recherche.</p>
    </div>

    @foreach($partners as $country => $data)
    @php $cc = $countryColors[$data['code']] ?? '#16a34a'; @endphp
    <div class="prc-country-panel">
        <div class="prc-country-head">
            <span class="prc-flag-badge">{{ $data['flag'] }}</span>
            <span class="prc-country-name">{{ $country }}</span>
            <span class="prc-country-count">{{ count($data['schools']) }} {{ count($data['schools']) > 1 ? 'établissements' : 'établissement' }}</span>
        </div>
        <div class="prc-partner-grid">
            @foreach($data['schools'] as $school)
            @php
                $words = preg_split('/\s+/', trim($school['name']));
                $initials = strtoupper(count($words) > 1 ? substr($words[0],0,1).substr($words[1],0,1) : substr($words[0],0,2));
            @endphp
            <div class="prc-partner-card">
                <span class="prc-partner-logo" style="background: {{ $cc }}1a; color: {{ $cc }};">{{ $initials }}</span>
                <span class="prc-partner-text">
                    <span class="prc-partner-name">{{ $school['name'] }}</span>
                    <span class="prc-partner-sub">{{ $school['sub'] }}</span>
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <p class="prc-source">
        Source officielle : <a href="https://ensa.uit.ac.ma/international/" target="_blank" rel="noopener">ensa.uit.ac.ma/international</a>
    </p>
</section>

<style>
/* ===== Programs ===== */
.prc-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 1.5rem; max-width: 1200px; margin: 3rem auto 0; padding: 0 1.5rem;
}
.prc-card {
    position: relative;
    border-radius: 20px; padding: 1.6rem; display: flex; flex-direction: column;
    border: 1px solid var(--border-color); transition: transform .25s, box-shadow .25s, border-color .25s;
}
.prc-card:hover { transform: translateY(-5px); box-shadow: var(--shadow-lg); }
.prc-card-clickable { cursor: pointer; }
.prc-card-clickable:hover { border-color: rgba(110,231,183,.55); }
.prc-link-stretched::after { content: ''; position: absolute; inset: 0; z-index: 1; border-radius: 20px; }
.prc-card-head { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.1rem; }
.prc-icon { width: 52px; height: 52px; border-radius: 15px; display: flex; align-items: center; justify-content: center; }
.prc-badge { font-size: .72rem; font-weight: 800; padding: 4px 12px; border-radius: 999px; text-transform: uppercase; letter-spacing: .03em; }
.prc-title { font-size: 1.2rem; font-weight: 800; color: var(--text-primary); margin: 0 0 2px; letter-spacing: -.02em; }
.prc-subtitle { font-size: .85rem; font-weight: 600; color: var(--text-muted); margin: 0 0 .9rem; }
.prc-desc { font-size: .88rem; line-height: 1.6; color: var(--text-muted); margin: 0 0 1.1rem; flex: 1; }
.prc-points { list-style: none; padding: 0; margin: 0 0 1rem; display: flex; flex-direction: column; gap: .55rem; }
.prc-points li { display: flex; align-items: center; gap: 9px; font-size: .85rem; font-weight: 600; color: var(--text-primary); }
.prc-points svg { flex-shrink: 0; }
.prc-link { display: inline-flex; align-items: center; gap: 7px; font-size: .88rem; font-weight: 800; text-decoration: none; margin-top: auto; transition: gap .2s; }
.prc-card-clickable:hover .prc-link { gap: 11px; }

/* ===== Partners ===== */
.prc-partners { max-width: 1100px; margin: 4.5rem auto 2rem; padding: 0 1.5rem; }
.prc-partners-head { text-align: center; margin-bottom: 2.5rem; }
.prc-partners-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: var(--success, #059669); }
.prc-partners-title { font-size: 2rem; font-weight: 900; color: var(--text-primary); letter-spacing: -.04em; margin: .35rem 0 .5rem; }
.prc-partners-sub { font-size: .92rem; color: var(--text-muted); max-width: 560px; margin: 0 auto; }

.prc-country-panel {
    background: rgba(255,255,255,.55); border: 1px solid var(--border-color);
    border-radius: 20px; padding: 1.5rem 1.6rem; margin-bottom: 1.5rem;
}
.prc-country-head { display: flex; align-items: center; gap: 12px; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px dashed var(--border-color); }
.prc-flag-badge { width: 38px; height: 38px; border-radius: 11px; background: var(--bg-tertiary, rgba(15,23,42,.05)); display: flex; align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0; }
.prc-country-name { font-size: 1.15rem; font-weight: 800; color: var(--text-primary); }
.prc-country-count { margin-left: auto; font-size: .78rem; font-weight: 700; color: var(--text-muted); background: var(--bg-tertiary, rgba(15,23,42,.05)); padding: 4px 12px; border-radius: 999px; }

.prc-partner-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: .85rem; }
.prc-partner-card {
    display: flex; align-items: center; gap: 12px;
    background: #fff; border: 1px solid var(--border-color); border-radius: 14px;
    padding: .9rem 1rem; transition: transform .18s, box-shadow .18s, border-color .18s;
}
.prc-partner-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md, 0 6px 18px rgba(15,23,42,.08)); border-color: rgba(110,231,183,.5); }
.prc-partner-logo { width: 42px; height: 42px; border-radius: 11px; display: flex; align-items: center; justify-content: center; font-size: .9rem; font-weight: 800; flex-shrink: 0; letter-spacing: -.02em; }
.prc-partner-text { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.prc-partner-name { font-size: .95rem; font-weight: 800; color: var(--text-primary); }
.prc-partner-sub { font-size: .76rem; color: var(--text-muted); line-height: 1.35; }

.prc-source { text-align: center; font-size: .82rem; color: var(--text-muted); margin-top: 1.75rem; }
.prc-source a { color: var(--success, #059669); font-weight: 700; }

@media (max-width: 600px) {
    .prc-country-panel { padding: 1.1rem; }
    .prc-partner-grid { grid-template-columns: 1fr; }
}
</style>
@endsection
