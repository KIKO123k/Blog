@extends('layouts.app')

@section('title', $major->title . ' — Filière ENSA Kénitra')

@section('content')
<div class="major-show-page">

    {{-- ── HERO BANNER ──────────────────────────────────────────── --}}
    <div class="major-hero">
        <div class="major-hero-bg"></div>
        <div class="major-hero-content">
            <a href="{{ route('majors.index') }}" class="major-back-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Retour aux filières
            </a>
            <div class="major-hero-badges">
                <span class="major-badge major-badge-cat">{{ $major->category_label }}</span>
                @if($major->duree_annees)
                    <span class="major-badge major-badge-dur">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        {{ $major->duree_annees }} ans
                    </span>
                @endif
            </div>
            <h1 class="major-hero-title">{{ $major->title }}</h1>
            <p class="major-hero-desc">{{ $major->description }}</p>

            <div class="major-hero-stats">
                <div class="major-stat">
                    <span class="major-stat-value">{{ $major->comments->count() }}</span>
                    <span class="major-stat-label">Commentaires</span>
                </div>
                <div class="major-stat-divider"></div>
                <div class="major-stat">
                    @php $avg = $major->avgRating(); @endphp
                    <span class="major-stat-value">{{ $avg > 0 ? number_format($avg,1).'/5' : '—' }}</span>
                    <span class="major-stat-label">Note moyenne</span>
                </div>
                @if($major->source_url)
                <div class="major-stat-divider"></div>
                <a href="{{ $major->source_url }}" target="_blank" rel="noopener noreferrer" class="major-official-btn">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
                    </svg>
                    Site officiel
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- ── MAIN CONTENT GRID ──────────────────────────────────────── --}}
    <div class="major-layout">

        {{-- ── LEFT COLUMN ─────────────────────────────────────────── --}}
        <div class="major-main">

            {{-- Objectifs --}}
            @if(!empty($major->objectifs))
            <section class="major-section">
                <div class="major-section-header">
                    <div class="major-section-icon icon-green">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <h2 class="major-section-title">Objectifs de la formation</h2>
                </div>
                <ul class="major-checklist">
                    @foreach($major->objectifs as $objectif)
                    <li class="major-checklist-item">
                        <span class="major-check-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span>{{ $objectif }}</span>
                    </li>
                    @endforeach
                </ul>
            </section>
            @endif

            {{-- Compétences --}}
            @if(!empty($major->competences))
            <section class="major-section">
                <div class="major-section-header">
                    <div class="major-section-icon icon-blue">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h2 class="major-section-title">Compétences visées</h2>
                </div>
                @if(is_array(array_values($major->competences)[0] ?? null))
                    <div class="major-competences-grid">
                        @foreach($major->competences as $group => $items)
                        <div class="major-competence-group">
                            <h3 class="major-competence-group-title">{{ $group }}</h3>
                            <ul class="major-dot-list">
                                @foreach($items as $item)
                                <li><span class="dot-green">•</span> {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="major-tags-wrap">
                        @foreach($major->competences as $item)
                            <span class="major-tag">{{ $item }}</span>
                        @endforeach
                    </div>
                @endif
            </section>
            @endif

            {{-- Programme --}}
            @if(!empty($major->programme))
            <section class="major-section">
                <div class="major-section-header">
                    <div class="major-section-icon icon-purple">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    </div>
                    <h2 class="major-section-title">Programme d'études</h2>
                </div>
                <div class="major-programme-grid">
                    @foreach($major->programme as $semester => $modules)
                    <div class="major-semester-card">
                        <div class="major-semester-title">{{ $semester }}</div>
                        <div class="major-modules-wrap">
                            @foreach($modules as $module)
                                <span class="major-module-tag">{{ $module }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Débouchés --}}
            @if(!empty($major->debouches))
            <section class="major-section">
                <div class="major-section-header">
                    <div class="major-section-icon icon-orange">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    </div>
                    <h2 class="major-section-title">Débouchés professionnels</h2>
                </div>
                @if(is_array(array_values($major->debouches)[0] ?? null))
                    <div class="major-competences-grid">
                        @foreach($major->debouches as $group => $items)
                        <div class="major-competence-group">
                            <h3 class="major-competence-group-title">{{ $group }}</h3>
                            <ul class="major-dot-list">
                                @foreach($items as $item)
                                <li><span class="dot-blue">➔</span> {{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="major-career-list">
                        @foreach($major->debouches as $item)
                        <div class="major-career-item">
                            <span class="major-career-arrow">→</span>
                            <span>{{ $item }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </section>
            @endif

            {{-- ── COMMENTS ─────────────────────────────────────────── --}}
            <section class="major-section">
                <div class="major-section-header">
                    <div class="major-section-icon icon-teal">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    </div>
                    <h2 class="major-section-title">Commentaires <span class="major-comment-count">{{ $major->comments->count() }}</span></h2>
                </div>

                @auth
                <form action="{{ route('majors.comments.store', $major->id) }}" method="POST" class="major-comment-form">
                    @csrf
                    <div class="major-comment-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="major-comment-input-wrap">
                        <textarea name="content" class="major-comment-textarea" required placeholder="Partagez votre avis sur cette filière..."></textarea>
                        <button type="submit" class="major-comment-submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                            Publier
                        </button>
                    </div>
                </form>
                @else
                <div class="major-login-prompt">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.
                </div>
                @endauth

                <div class="major-comments-list">
                    @forelse($major->comments as $comment)
                    <div class="major-comment-card">
                        <div class="major-comment-avatar-sm">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</div>
                        <div class="major-comment-body">
                            <div class="major-comment-meta">
                                <strong>{{ $comment->user->name }}</strong>
                                <span>{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="major-empty-comments">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <p>Aucun commentaire pour le moment.</p>
                    </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- ── RIGHT SIDEBAR ─────────────────────────────────────────── --}}
        <aside class="major-sidebar">

            {{-- Rating card --}}
            <div class="major-sidebar-card">
                <h3 class="major-sidebar-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    Note de la filière
                </h3>
                @php $avg = $major->avgRating(); @endphp
                @if($avg > 0)
                <div class="major-avg-score">
                    <span class="major-avg-number">{{ number_format($avg, 1) }}</span>
                    <span class="major-avg-max">/5</span>
                </div>
                <div class="major-stars-display">
                    @for($i = 1; $i <= 5; $i++)
                    <svg class="star-icon {{ $i <= round($avg) ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor" style="width:22px;height:22px;"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    @endfor
                </div>
                @else
                <p class="major-no-rating">Pas encore noté</p>
                @endif

                @auth
                <div class="major-rate-divider"></div>
                <p class="major-rate-label">Votre note</p>
                <form action="{{ route('majors.rate', $major->id) }}" method="POST" id="rating-form">
                    @csrf
                    <input type="hidden" name="rating" id="selected-rating" value="{{ $userRating->rating ?? 0 }}">
                    <div class="major-rate-stars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setRating({{ $i }})" class="star-btn" title="{{ $i }} étoile{{ $i > 1 ? 's' : '' }}">
                            <svg id="star-{{ $i }}" class="star-icon cursor-pointer {{ ($userRating && $userRating->rating >= $i) ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor" style="width:30px;height:30px;">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </button>
                        @endfor
                    </div>
                    <button type="submit" class="major-rate-submit">Enregistrer ma note</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="major-login-link">Connectez-vous pour noter</a>
                @endauth
            </div>

            {{-- Conditions d'accès --}}
            @if(!empty($major->acces))
            <div class="major-sidebar-card">
                <h3 class="major-sidebar-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    Conditions d'accès
                </h3>
                <ul class="major-sidebar-list">
                    @foreach($major->acces as $cond)
                    <li>
                        <span class="sidebar-check">✓</span>
                        {{ $cond }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Partenariats --}}
            @if(!empty($major->partenariats))
            <div class="major-sidebar-card">
                <h3 class="major-sidebar-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Partenariats
                </h3>
                <ul class="major-sidebar-list">
                    @foreach($major->partenariats as $part)
                    <li>
                        <span class="sidebar-star">★</span>
                        {{ $part }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Vidéo --}}
            <div class="major-sidebar-card">
                <h3 class="major-sidebar-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    Vidéo de présentation
                </h3>
                @if($major->video_url && $major->youtube_embed_url)
                <div class="major-video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; border-radius: 12px; box-shadow: var(--shadow-sm); margin-bottom: 10px;">
                    <iframe src="{{ $major->youtube_embed_url }}" 
                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                    </iframe>
                </div>
                @elseif($major->video_url)
                <video controls class="major-video" style="width: 100%; border-radius: 12px; box-shadow: var(--shadow-sm); margin-bottom: 10px;">
                    <source src="{{ $major->video_url }}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                </video>
                @elseif($major->video_path)
                <div class="major-video-box" id="majorVideoBox">
                    <video class="major-video" id="majorVideo" preload="metadata" playsinline>
                        <source src="{{ asset('storage/' . $major->video_path) }}#t=0.1" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                    <button type="button" class="major-video-play" id="majorVideoPlay" aria-label="Lire la vidéo">
                        <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><polygon points="6 4 20 12 6 20 6 4"/></svg>
                    </button>
                </div>
                <script>
                    (function () {
                        var box = document.getElementById('majorVideoBox');
                        var vid = document.getElementById('majorVideo');
                        var btn = document.getElementById('majorVideoPlay');
                        if (!box || !vid || !btn) return;
                        btn.addEventListener('click', function () {
                            vid.controls = true;          // contrôles natifs (pause, volume, plein écran)
                            vid.play();
                        });
                        vid.addEventListener('play',  function () { box.classList.add('is-playing'); });
                        vid.addEventListener('pause', function () { if (!vid.ended) box.classList.remove('is-playing'); });
                        vid.addEventListener('ended', function () { box.classList.remove('is-playing'); });
                    })();
                </script>
                @else
                <div class="major-video-placeholder">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.4"><polygon points="23 7 16 12 23 17 23 7"/><rect x="1" y="5" width="15" height="14" rx="2" ry="2"/></svg>
                    <span>Vidéo bientôt disponible</span>
                </div>
                @endif
            </div>

        </aside>
    </div>
</div>

<style>
/* ─────────────────────────────────────────────────────────────────
   MAJOR SHOW PAGE — Modern Design
───────────────────────────────────────────────────────────────── */

.major-show-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1.5rem 4rem;
}

/* ── HERO ── */
.major-hero {
    position: relative;
    border-radius: 0 0 32px 32px;
    overflow: hidden;
    padding: 3rem 2.5rem 2.5rem;
    margin: 0 -1.5rem 2.5rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #064e3b 100%);
    color: white;
}
.major-hero-bg {
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse at 80% 20%, rgba(110,231,183,0.18) 0%, transparent 60%),
        radial-gradient(ellipse at 10% 80%, rgba(99,102,241,0.12) 0%, transparent 50%);
    pointer-events: none;
}
.major-hero-content { position: relative; z-index: 1; max-width: 800px; }

.major-back-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 0.85rem;
    color: rgba(255,255,255,0.6);
    margin-bottom: 1.5rem;
    transition: color 0.2s;
}
.major-back-link:hover { color: var(--primary); }

.major-hero-badges {
    display: flex;
    gap: 10px;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}
.major-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 14px;
    border-radius: 999px;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}
.major-badge-cat {
    background: rgba(110,231,183,0.15);
    color: #6EE7B7;
    border: 1px solid rgba(110,231,183,0.3);
}
.major-badge-dur {
    background: rgba(255,255,255,0.08);
    color: rgba(255,255,255,0.8);
    border: 1px solid rgba(255,255,255,0.15);
}

.major-hero-title {
    font-size: clamp(1.8rem, 4vw, 2.8rem);
    font-family: var(--font-heading);
    font-weight: 800;
    line-height: 1.15;
    color: white;
    margin-bottom: 1rem;
    letter-spacing: -0.03em;
}

.major-hero-desc {
    font-size: 1rem;
    color: rgba(255,255,255,0.7);
    line-height: 1.7;
    max-width: 680px;
    margin-bottom: 2rem;
}

.major-hero-stats {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}
.major-stat { text-align: center; }
.major-stat-value {
    display: block;
    font-size: 1.4rem;
    font-weight: 700;
    color: white;
    font-family: var(--font-heading);
}
.major-stat-label {
    font-size: 0.75rem;
    color: rgba(255,255,255,0.5);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.major-stat-divider {
    width: 1px;
    height: 36px;
    background: rgba(255,255,255,0.12);
}
.major-official-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 8px 18px;
    background: var(--gradient-primary);
    color: #0f172a !important;
    border-radius: 999px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: opacity 0.2s, transform 0.2s;
    text-decoration: none;
}
.major-official-btn:hover { opacity: 0.88; transform: translateY(-1px); }

/* ── LAYOUT ── */
.major-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 2rem;
    align-items: start;
}
@media (max-width: 900px) {
    .major-layout { grid-template-columns: 1fr; }
    .major-sidebar { order: -1; }
}

/* ── SECTIONS ── */
.major-section {
    background: rgba(255,255,255,0.75);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 1.75rem;
    margin-bottom: 1.5rem;
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow-md);
    transition: box-shadow 0.25s;
}
.major-section:hover { box-shadow: var(--shadow-lg); }

.major-section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 1.25rem;
}
.major-section-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.icon-green  { background: rgba(16,185,129,0.12); color: #059669; }
.icon-blue   { background: rgba(59,130,246,0.12);  color: #2563eb; }
.icon-purple { background: rgba(139,92,246,0.12);  color: #7c3aed; }
.icon-orange { background: rgba(249,115,22,0.12);  color: #ea580c; }
.icon-teal   { background: rgba(20,184,166,0.12);  color: #0d9488; }

.major-section-title {
    font-size: 1.15rem;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 10px;
}
.major-comment-count {
    background: var(--primary-glow);
    color: var(--success);
    font-size: 0.8rem;
    font-weight: 700;
    padding: 2px 10px;
    border-radius: 999px;
    border: 1px solid rgba(110,231,183,0.3);
}

/* ── CHECKLIST ── */
.major-checklist { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.major-checklist-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.95rem;
    color: var(--text-secondary);
    line-height: 1.5;
}
.major-check-icon {
    width: 22px;
    height: 22px;
    background: rgba(16,185,129,0.12);
    color: #059669;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

/* ── COMPETENCES GRID ── */
.major-competences-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1rem;
}
.major-competence-group {
    background: rgba(248,250,252,0.8);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    padding: 1rem 1.25rem;
}
.major-competence-group-title {
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--text-primary);
    text-transform: uppercase;
    letter-spacing: 0.04em;
    border-bottom: 1px solid var(--border-color);
    padding-bottom: 8px;
    margin-bottom: 10px;
}
.major-dot-list { list-style: none; display: flex; flex-direction: column; gap: 6px; }
.major-dot-list li {
    font-size: 0.875rem;
    color: var(--text-secondary);
    display: flex;
    align-items: flex-start;
    gap: 6px;
    line-height: 1.4;
}
.dot-green { color: #059669; font-weight: bold; flex-shrink: 0; }
.dot-blue  { color: #2563eb; font-weight: bold; flex-shrink: 0; }

/* ── TAGS ── */
.major-tags-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}
.major-tag {
    background: rgba(110,231,183,0.12);
    color: #065f46;
    border: 1px solid rgba(110,231,183,0.35);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.83rem;
    font-weight: 500;
    transition: background 0.2s;
}
.major-tag:hover { background: rgba(110,231,183,0.22); }

/* ── PROGRAMME ── */
.major-programme-grid { display: flex; flex-direction: column; gap: 12px; }
.major-semester-card {
    border: 1px solid var(--border-color);
    border-radius: 14px;
    overflow: hidden;
}
.major-semester-title {
    background: linear-gradient(90deg, rgba(110,231,183,0.12), rgba(52,211,153,0.06));
    padding: 10px 16px;
    font-size: 0.88rem;
    font-weight: 700;
    color: #065f46;
    border-bottom: 1px solid rgba(110,231,183,0.2);
}
.major-modules-wrap {
    padding: 12px 14px;
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    background: rgba(255,255,255,0.5);
}
.major-module-tag {
    background: white;
    border: 1px solid rgba(15,23,42,0.08);
    border-radius: 8px;
    padding: 4px 12px;
    font-size: 0.78rem;
    color: var(--text-secondary);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}

/* ── CAREER LIST ── */
.major-career-list { display: flex; flex-direction: column; gap: 10px; }
.major-career-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    background: rgba(248,250,252,0.8);
    border: 1px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.92rem;
    color: var(--text-secondary);
    transition: border-color 0.2s, background 0.2s;
}
.major-career-item:hover {
    border-color: rgba(110,231,183,0.4);
    background: rgba(110,231,183,0.05);
}
.major-career-arrow {
    color: var(--primary-hover);
    font-size: 1.1rem;
    font-weight: 700;
    flex-shrink: 0;
}

/* ── COMMENT FORM ── */
.major-comment-form {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 1.5rem;
}
.major-comment-avatar {
    width: 40px;
    height: 40px;
    min-width: 40px;
    background: var(--gradient-primary);
    color: #0f172a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.95rem;
    font-family: var(--font-heading);
}
.major-comment-input-wrap { flex: 1; display: flex; flex-direction: column; gap: 8px; }
.major-comment-textarea {
    width: 100%;
    min-height: 80px;
    padding: 12px 14px;
    background: rgba(15,23,42,0.03);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    font-family: var(--font-body);
    font-size: 0.9rem;
    color: var(--text-primary);
    resize: vertical;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.major-comment-textarea:focus {
    border-color: rgba(110,231,183,0.5);
    box-shadow: 0 0 0 3px rgba(110,231,183,0.12);
}
.major-comment-submit {
    align-self: flex-end;
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 20px;
    background: var(--gradient-primary);
    color: #0f172a;
    border: none;
    border-radius: 10px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    transition: opacity 0.2s, transform 0.2s;
    font-family: var(--font-body);
}
.major-comment-submit:hover { opacity: 0.88; transform: translateY(-1px); }

.major-login-prompt {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 12px 16px;
    background: rgba(15,23,42,0.03);
    border: 1px dashed var(--border-color);
    border-radius: 12px;
    font-size: 0.9rem;
    color: var(--text-muted);
    margin-bottom: 1.5rem;
}
.major-login-prompt a { color: var(--success); font-weight: 600; }
.major-login-prompt a:hover { text-decoration: underline; }

/* ── COMMENTS LIST ── */
.major-comments-list { display: flex; flex-direction: column; gap: 12px; }
.major-comment-card {
    display: flex;
    gap: 12px;
    align-items: flex-start;
    padding: 14px;
    background: rgba(248,250,252,0.7);
    border: 1px solid var(--border-color);
    border-radius: 14px;
    transition: border-color 0.2s;
}
.major-comment-card:hover { border-color: rgba(110,231,183,0.35); }
.major-comment-avatar-sm {
    width: 36px;
    height: 36px;
    min-width: 36px;
    background: var(--gradient-primary);
    color: #0f172a;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 0.85rem;
    font-family: var(--font-heading);
}
.major-comment-body { flex: 1; }
.major-comment-meta {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
}
.major-comment-meta strong { font-size: 0.9rem; color: var(--text-primary); }
.major-comment-meta span { font-size: 0.78rem; color: var(--text-muted); }
.major-comment-body p { font-size: 0.9rem; color: var(--text-secondary); line-height: 1.6; }

.major-empty-comments {
    text-align: center;
    padding: 2.5rem 1rem;
    color: var(--text-muted);
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
}
.major-empty-comments p { font-size: 0.9rem; }

/* ── SIDEBAR ── */
.major-sidebar { display: flex; flex-direction: column; gap: 1.25rem; }
.major-sidebar-card {
    background: rgba(255,255,255,0.8);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 1.5rem;
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow-md);
}
.major-sidebar-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    font-family: var(--font-heading);
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.major-avg-score {
    text-align: center;
    margin-bottom: 8px;
}
.major-avg-number {
    font-size: 3rem;
    font-weight: 800;
    font-family: var(--font-heading);
    background: var(--gradient-text);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    line-height: 1;
}
.major-avg-max { font-size: 1.2rem; color: var(--text-muted); font-weight: 500; }
.major-stars-display { display: flex; justify-content: center; gap: 4px; margin-bottom: 4px; }
.major-no-rating { text-align: center; color: var(--text-muted); font-size: 0.9rem; font-style: italic; }

.major-rate-divider { height: 1px; background: var(--border-color); margin: 1rem 0; }
.major-rate-label { font-size: 0.85rem; font-weight: 600; color: var(--text-secondary); margin-bottom: 10px; text-align: center; }
.major-rate-stars { display: flex; justify-content: center; gap: 4px; margin-bottom: 12px; }
.star-btn { background: none; border: none; cursor: pointer; padding: 2px; transition: transform 0.15s; }
.star-btn:hover { transform: scale(1.2); }
.major-rate-submit {
    width: 100%;
    padding: 10px;
    background: var(--gradient-primary);
    color: #0f172a;
    border: none;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.88rem;
    cursor: pointer;
    transition: opacity 0.2s;
    font-family: var(--font-body);
}
.major-rate-submit:hover { opacity: 0.88; }
.major-login-link {
    display: block;
    text-align: center;
    margin-top: 0.75rem;
    font-size: 0.85rem;
    color: var(--success);
    font-weight: 600;
}

.major-sidebar-list { list-style: none; display: flex; flex-direction: column; gap: 8px; }
.major-sidebar-list li {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    font-size: 0.875rem;
    color: var(--text-secondary);
    line-height: 1.45;
}
.sidebar-check { color: #059669; font-weight: 800; flex-shrink: 0; }
.sidebar-star  { color: #d97706; font-weight: 700; flex-shrink: 0; }

.major-video {
    width: 100%;
    border-radius: 12px;
    background: #000;
    display: block;
}
/* Lecteur vidéo avec bouton "start" personnalisé */
.major-video-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    margin-bottom: 10px;
    background: #000;
}
.major-video-box .major-video { width: 100%; height: auto; max-height: 60vh; object-fit: contain; }
.major-video-play {
    position: absolute;
    inset: 0;
    margin: auto;
    width: 66px;
    height: 66px;
    border: none;
    border-radius: 50%;
    background: linear-gradient(135deg, #6EE7B7, #34d399);
    color: #0f172a;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    padding-left: 4px; /* recentre l'icône triangle */
    box-shadow: 0 8px 24px rgba(0,0,0,0.35), 0 0 0 6px rgba(110,231,183,0.25);
    transition: transform .2s, box-shadow .2s, opacity .25s;
    animation: majorPlayPulse 2.2s ease-in-out infinite;
}
.major-video-play:hover { transform: scale(1.08); box-shadow: 0 10px 30px rgba(0,0,0,0.4), 0 0 0 8px rgba(110,231,183,0.3); }
.major-video-box::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.35), transparent 55%);
    pointer-events: none;
    transition: opacity .25s;
}
/* Pendant la lecture : on cache le bouton + le voile */
.major-video-box.is-playing .major-video-play { opacity: 0; pointer-events: none; transform: scale(.6); }
.major-video-box.is-playing::after { opacity: 0; }
@keyframes majorPlayPulse {
    0%, 100% { box-shadow: 0 8px 24px rgba(0,0,0,0.35), 0 0 0 0 rgba(110,231,183,0.45); }
    50%      { box-shadow: 0 8px 24px rgba(0,0,0,0.35), 0 0 0 12px rgba(110,231,183,0); }
}
.major-video-placeholder {
    aspect-ratio: 16/9;
    background: rgba(15,23,42,0.04);
    border: 1px dashed var(--border-color);
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: var(--text-muted);
    font-size: 0.85rem;
}

/* Star icon states */
.star-icon { color: #f59e0b; transition: color 0.15s; }
.star-icon.empty { color: #d1d5db; }
</style>

<script>
function setRating(val) {
    document.getElementById('selected-rating').value = val;
    for (let i = 1; i <= 5; i++) {
        const star = document.getElementById('star-' + i);
        if (i <= val) star.classList.remove('empty');
        else star.classList.add('empty');
    }
}
</script>
@endsection
