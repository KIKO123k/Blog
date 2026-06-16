@extends('layouts.app')

@section('title', 'Clubs & Associations — ENSA Kénitra')

@section('content')
<div class="clubs-page">

    {{-- HERO --}}
    <div class="clubs-hero">
        <div class="clubs-hero-bg"></div>
        <div class="clubs-hero-content">
            <span class="clubs-hero-eyebrow">Vie estudiantine</span>
            <h1 class="clubs-hero-title">Clubs &amp; <span class="gradient-title">Associations</span></h1>
            <p class="clubs-hero-sub">Rejoignez une communauté, développez vos compétences et vivez l'expérience ENSA Kénitra à fond.</p>

            <form action="{{ route('clubs.index') }}" method="GET" class="clubs-search-form">
                <div class="clubs-search-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un club..." class="clubs-search-input">
                    @if(request('search'))
                        <a href="{{ route('clubs.index') }}" class="clubs-search-clear">✕</a>
                    @endif
                </div>
                <button type="submit" class="clubs-search-btn">Rechercher</button>
            </form>
        </div>
    </div>

    {{-- STATS BAR --}}
    <div class="clubs-stats-bar">
        <div class="clubs-stat">
            <strong>{{ $clubs->total() }}</strong>
            <span>Club{{ $clubs->total() > 1 ? 's' : '' }}</span>
        </div>
        <div class="clubs-stat-sep"></div>
        <div class="clubs-stat">
            <strong>8</strong>
            <span>Domaines</span>
        </div>
        <div class="clubs-stat-sep"></div>
        <div class="clubs-stat">
            <strong>+500</strong>
            <span>Membres actifs</span>
        </div>
    </div>

    {{-- GRID --}}
    @if($clubs->isEmpty())
        <div class="clubs-empty">
            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity="0.25">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <p>Aucun club trouvé pour « {{ request('search') }} »</p>
            <a href="{{ route('clubs.index') }}" class="clubs-reset-btn">Voir tous les clubs</a>
        </div>
    @else
    <div class="clubs-grid">
        @foreach($clubs as $club)
        <a href="{{ route('clubs.show', $club) }}" class="club-card" data-theme="{{ $club->theme }}" style="text-decoration:none;color:inherit;display:flex;flex-direction:column;gap:1rem;">
            <div class="club-card-top">
                <div class="club-icon-wrap">
                    @php
                        $icons = [
                            'code'       => '<path d="M16 18l6-6-6-6"/><path d="M8 6l-6 6 6 6"/>',
                            'robotics'   => '<rect x="3" y="11" width="18" height="10" rx="2"/><path d="M12 11V5"/><circle cx="12" cy="3" r="2"/><path d="M7 15h0M12 15h0M17 15h0"/>',
                            'ai'         => '<path d="M12 2a4 4 0 0 1 4 4v1h1a3 3 0 0 1 0 6h-1v1a4 4 0 0 1-8 0v-1H7a3 3 0 0 1 0-6h1V6a4 4 0 0 1 4-4z"/>',
                            'cyber'      => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                            'network'    => '<circle cx="12" cy="5" r="3"/><circle cx="5" cy="19" r="3"/><circle cx="19" cy="19" r="3"/><path d="M12 8v3M9.7 16.5L7 17.5M14.3 16.5L17 17.5"/>',
                            'industrial' => '<circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/>',
                            'management' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                            'leadership' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
                            'social'     => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
                        ];
                        $iconPath = $icons[$club->theme] ?? $icons['code'];
                    @endphp
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        {!! $iconPath !!}
                    </svg>
                </div>
                <span class="club-acronym">{{ $club->acronym }}</span>
            </div>
            <div class="club-card-body">
                <h3 class="club-name">{{ $club->name }}</h3>
                <p class="club-desc">{{ Str::limit($club->description, 120) }}</p>
            </div>
            <div class="club-card-footer">
                <span class="club-theme-badge">{{ ucfirst($club->theme) }}</span>
                <span class="club-card-discover">Découvrir →</span>
            </div>
        </a>
        @endforeach
    </div>

    {{-- PAGINATION --}}
    @if($clubs->hasPages())
    <div class="clubs-pagination">
        {{ $clubs->links() }}
    </div>
    @endif
    @endif

</div>

<style>
/* ── CLUBS PAGE ───────────────────────────────────────────── */
.clubs-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem 4rem;
}

/* HERO */
.clubs-hero {
    position: relative;
    border-radius: 0 0 32px 32px;
    overflow: hidden;
    padding: 3rem 2.5rem 2.5rem;
    margin: 0 -1.5rem 2rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #134e4a 100%);
    color: white;
    text-align: center;
}
.clubs-hero-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 75% 30%, rgba(110,231,183,0.15) 0%, transparent 55%),
        radial-gradient(ellipse at 20% 70%, rgba(99,102,241,0.1) 0%, transparent 50%);
    pointer-events: none;
}
.clubs-hero-content { position: relative; z-index: 1; max-width: 620px; margin: 0 auto; }

.clubs-hero-eyebrow {
    display: inline-block;
    background: rgba(110,231,183,0.15);
    color: #6EE7B7;
    border: 1px solid rgba(110,231,183,0.3);
    padding: 4px 16px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 1rem;
}
.clubs-hero-title {
    font-size: clamp(2rem, 5vw, 3rem);
    font-family: var(--font-heading);
    font-weight: 800;
    color: white;
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 0.75rem;
}
.clubs-hero-sub {
    font-size: 1rem;
    color: rgba(255,255,255,0.65);
    margin-bottom: 2rem;
    line-height: 1.6;
}

/* SEARCH */
.clubs-search-form { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
.clubs-search-box {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 12px;
    padding: 0 16px;
    flex: 1;
    max-width: 400px;
    backdrop-filter: blur(8px);
}
.clubs-search-box svg { color: rgba(255,255,255,0.5); flex-shrink: 0; }
.clubs-search-input {
    flex: 1;
    background: none;
    border: none;
    outline: none;
    color: white;
    font-size: 0.9rem;
    padding: 12px 0;
    font-family: var(--font-body);
}
.clubs-search-input::placeholder { color: rgba(255,255,255,0.4); }
.clubs-search-clear { color: rgba(255,255,255,0.5); font-size: 0.85rem; cursor: pointer; line-height: 1; }
.clubs-search-clear:hover { color: white; }
.clubs-search-btn {
    padding: 12px 24px;
    background: var(--gradient-primary);
    color: #0f172a;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    font-family: var(--font-body);
    transition: opacity 0.2s;
    white-space: nowrap;
}
.clubs-search-btn:hover { opacity: 0.88; }

/* STATS BAR */
.clubs-stats-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 2rem;
    padding: 1.25rem 2rem;
    background: rgba(255,255,255,0.75);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    margin-bottom: 2.5rem;
    backdrop-filter: blur(12px);
}
.clubs-stat { text-align: center; }
.clubs-stat strong { display: block; font-size: 1.4rem; font-weight: 800; font-family: var(--font-heading); background: var(--gradient-text); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.clubs-stat span { font-size: 0.78rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; }
.clubs-stat-sep { width: 1px; height: 36px; background: var(--border-color); }

/* GRID */
.clubs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
}

/* CARD */
.club-card {
    background: rgba(255,255,255,0.78);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    transition: transform 0.25s, box-shadow 0.25s, border-color 0.25s;
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow-sm);
}
.club-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: rgba(110,231,183,0.4);
}

.club-card-top { display: flex; align-items: center; justify-content: space-between; }

.club-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.2s;
}

/* Theme colors for icon background */
.club-card[data-theme="code"]       .club-icon-wrap { background: rgba(59,130,246,0.12);  color: #2563eb; }
.club-card[data-theme="robotics"]   .club-icon-wrap { background: rgba(239,68,68,0.1);    color: #dc2626; }
.club-card[data-theme="ai"]         .club-icon-wrap { background: rgba(139,92,246,0.12);  color: #7c3aed; }
.club-card[data-theme="cyber"]      .club-icon-wrap { background: rgba(234,179,8,0.12);   color: #b45309; }
.club-card[data-theme="network"]    .club-icon-wrap { background: rgba(20,184,166,0.12);  color: #0d9488; }
.club-card[data-theme="industrial"] .club-icon-wrap { background: rgba(249,115,22,0.12);  color: #ea580c; }
.club-card[data-theme="management"] .club-icon-wrap { background: rgba(16,185,129,0.12);  color: #059669; }
.club-card[data-theme="leadership"] .club-icon-wrap { background: rgba(236,72,153,0.1);   color: #db2777; }
.club-card[data-theme="social"]     .club-icon-wrap { background: rgba(110,231,183,0.15); color: #065f46; }

.club-acronym {
    font-size: 0.78rem;
    font-weight: 700;
    letter-spacing: 0.06em;
    color: var(--text-muted);
    background: rgba(15,23,42,0.05);
    padding: 4px 10px;
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.club-card-body { flex: 1; }
.club-name {
    font-size: 1.05rem;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--text-primary);
    margin-bottom: 8px;
    line-height: 1.3;
}
.club-desc {
    font-size: 0.875rem;
    color: var(--text-muted);
    line-height: 1.6;
}

.club-card-footer { display: flex; align-items: center; justify-content: space-between; padding-top: 0.5rem; border-top: 1px solid var(--border-color); }
.club-card-discover { font-size: 0.8rem; font-weight: 600; color: var(--success); transition: gap 0.2s; }
.club-card:hover .club-card-discover { letter-spacing: 0.02em; }
.club-theme-badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 3px 12px;
    border-radius: 999px;
    background: var(--primary-glow);
    color: var(--success);
    border: 1px solid rgba(110,231,183,0.3);
}

/* EMPTY */
.clubs-empty {
    text-align: center;
    padding: 5rem 2rem;
    color: var(--text-muted);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
}
.clubs-empty p { font-size: 1rem; }
.clubs-reset-btn {
    display: inline-block;
    margin-top: 4px;
    padding: 8px 20px;
    background: var(--gradient-primary);
    color: #0f172a;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.85rem;
    transition: opacity 0.2s;
}
.clubs-reset-btn:hover { opacity: 0.85; }

/* PAGINATION */
.clubs-pagination { margin-top: 2.5rem; display: flex; justify-content: center; }
</style>
@endsection
