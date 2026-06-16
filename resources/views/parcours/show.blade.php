@extends('layouts.app')

@section('title', $p['title'] . ' – ENSA Kénitra')

@php
    $icons = [
        'book'    => '<path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>',
        'cap'     => '<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
        'atom'    => '<circle cx="12" cy="12" r="1"/><path d="M20.2 20.2c2.04-2.03.02-7.36-4.5-11.9-4.54-4.52-9.87-6.54-11.9-4.5-2.04 2.03-.02 7.36 4.5 11.9 4.54 4.52 9.87 6.54 11.9 4.5Z"/><path d="M15.7 15.7c4.52-4.54 6.54-9.87 4.5-11.9-2.03-2.04-7.36-.02-11.9 4.5-4.52 4.54-6.54 9.87-4.5 11.9 2.03 2.04 7.36.02 11.9-4.5Z"/>',
        'diploma' => '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
        'plane'   => '<path d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.1-1.1.5l-.3.5c-.2.5-.1 1 .3 1.3L9 12l-2 3H4l-1 1 3 2 2 3 1-1v-3l3-2 3.5 5.3c.3.4.8.5 1.3.3l.5-.2c.4-.3.6-.7.5-1.2z"/>',
    ];
    $icon = $icons[$p['icon']] ?? $icons['book'];
@endphp

@section('content')
<div class="prd-page">

    <a href="{{ route('parcours.index') }}" class="prd-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
        Toutes les formations
    </a>

    {{-- HERO --}}
    <div class="prd-hero" style="--accent: {{ $p['color'] }};">
        <div class="prd-hero-bg"></div>
        <div class="prd-hero-inner">
            <span class="prd-icon">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icon !!}</svg>
            </span>
            <span class="prd-badge">{{ $p['badge'] }}</span>
            <h1 class="prd-title">{{ $p['title'] }}</h1>
            <p class="prd-subtitle">{{ $p['subtitle'] }}</p>
        </div>
    </div>

    {{-- INTRO --}}
    <div class="prd-intro glass">
        <p>{{ $p['intro'] }}</p>
    </div>

    {{-- SECTIONS --}}
    <div class="prd-sections">
        @foreach($p['sections'] as $section)
        <div class="prd-section glass">
            <h2 class="prd-section-title">
                <span class="prd-section-dot" style="background: {{ $p['color'] }};"></span>
                {{ $section['title'] }}
            </h2>
            <ul class="prd-list">
                @foreach($section['items'] as $item)
                <li>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="{{ $p['color'] }}" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    {{ $item }}
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    {{-- CTA --}}
    <div class="prd-cta glass">
        <div>
            <h3>Intéressé par ce parcours ?</h3>
            <p>Découvrez l'ensemble de l'offre de formation de l'ENSA Kénitra ou consultez le site officiel.</p>
        </div>
        <div class="prd-cta-actions">
            <a href="{{ route('parcours.index') }}" class="prd-btn prd-btn-ghost">Voir les autres formations</a>
            <a href="https://ensa.uit.ac.ma/" target="_blank" rel="noopener" class="prd-btn prd-btn-primary" style="background: {{ $p['color'] }};">Site officiel ENSA →</a>
        </div>
    </div>
</div>

<style>
.prd-page { max-width: 920px; margin: 0 auto; padding: 1.5rem 1.5rem 4rem; }

.prd-back { display: inline-flex; align-items: center; gap: 7px; font-size: .85rem; font-weight: 700; color: var(--text-muted); text-decoration: none; margin-bottom: 1.25rem; transition: color .18s, gap .18s; }
.prd-back:hover { color: var(--text-primary); gap: 11px; }

/* HERO */
.prd-hero {
    position: relative; overflow: hidden; text-align: center;
    border-radius: 24px; padding: 2.75rem 2rem 2.5rem; margin-bottom: 1.5rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, color-mix(in srgb, var(--accent) 35%, #1e293b) 100%);
    color: #fff;
}
.prd-hero-bg { position: absolute; inset: 0; background: radial-gradient(ellipse at 80% 20%, color-mix(in srgb, var(--accent) 40%, transparent) 0%, transparent 55%); pointer-events: none; }
.prd-hero-inner { position: relative; z-index: 1; display: flex; flex-direction: column; align-items: center; }
.prd-icon { width: 72px; height: 72px; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: color-mix(in srgb, var(--accent) 25%, transparent); color: #fff; margin-bottom: 1rem; border: 1px solid color-mix(in srgb, var(--accent) 45%, transparent); }
.prd-badge { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; padding: 4px 14px; border-radius: 999px; background: color-mix(in srgb, var(--accent) 30%, transparent); color: #fff; margin-bottom: .85rem; }
.prd-title { font-size: clamp(1.6rem, 4vw, 2.4rem); font-weight: 900; letter-spacing: -.04em; margin: 0 0 .35rem; color: #fff; }
.prd-subtitle { font-size: 1rem; font-weight: 600; color: rgba(255,255,255,.7); margin: 0; }

/* INTRO */
.prd-intro { border: 1px solid var(--border-color); border-radius: 18px; padding: 1.5rem 1.75rem; margin-bottom: 1.5rem; }
.prd-intro p { font-size: 1rem; line-height: 1.75; color: var(--text-primary); margin: 0; }

/* SECTIONS */
.prd-sections { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.25rem; margin-bottom: 1.5rem; }
.prd-section { border: 1px solid var(--border-color); border-radius: 18px; padding: 1.4rem 1.5rem; }
.prd-section-title { display: flex; align-items: center; gap: 10px; font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin: 0 0 1rem; }
.prd-section-dot { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
.prd-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .7rem; }
.prd-list li { display: flex; align-items: flex-start; gap: 10px; font-size: .9rem; line-height: 1.5; color: var(--text-primary); font-weight: 500; }
.prd-list svg { flex-shrink: 0; margin-top: 2px; }

/* CTA */
.prd-cta { display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; flex-wrap: wrap; border: 1px solid var(--border-color); border-radius: 20px; padding: 1.6rem 1.75rem; }
.prd-cta h3 { font-size: 1.15rem; font-weight: 800; color: var(--text-primary); margin: 0 0 .25rem; }
.prd-cta p { font-size: .88rem; color: var(--text-muted); margin: 0; max-width: 420px; }
.prd-cta-actions { display: flex; gap: .6rem; flex-wrap: wrap; }
.prd-btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 12px; font-size: .85rem; font-weight: 700; text-decoration: none; transition: opacity .18s, transform .18s; }
.prd-btn:hover { transform: translateY(-2px); }
.prd-btn-primary { color: #fff; }
.prd-btn-primary:hover { opacity: .9; }
.prd-btn-ghost { background: var(--bg-tertiary, rgba(15,23,42,.05)); color: var(--text-primary); border: 1px solid var(--border-color); }

@media (max-width: 600px) {
    .prd-cta { flex-direction: column; align-items: flex-start; }
    .prd-cta-actions { width: 100%; }
    .prd-btn { flex: 1; justify-content: center; }
}
</style>
@endsection
