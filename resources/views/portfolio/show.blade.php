@extends('layouts.app')
@section('title', $user->name . ' — Portfolio Étudiant')

@section('content')
<div class="pf-page">

    {{-- HERO --}}
    <div class="pf-hero">
        <div class="pf-hero-bg"></div>
        <div class="pf-hero-inner">
            <div class="pf-avatar-wrap">
                @if($user->avatar_path)
                    <img src="{{ Storage::url($user->avatar_path) }}" alt="{{ $user->name }}" class="pf-avatar">
                @else
                    <div class="pf-avatar-initials">{{ strtoupper(substr($user->name,0,2)) }}</div>
                @endif
            </div>
            <div class="pf-hero-info">
                <span class="pf-badge">Étudiant ingénieur · ENSA Kénitra</span>
                <h1 class="pf-name">{{ $user->name }}</h1>

                @if($user->filiere || $user->promotion)
                <p class="pf-filiere">
                    @if($user->filiere){{ $user->filiere }}@endif
                    @if($user->filiere && $user->promotion) · @endif
                    @if($user->promotion)Promotion {{ $user->promotion }}@endif
                </p>
                @endif

                @if($user->bio)
                <p class="pf-bio">{{ $user->bio }}</p>
                @endif

                {{-- SOCIAL BUTTONS — always visible, greyed out if not set --}}
                <div class="pf-socials">
                    {{-- Email --}}
                    <a href="mailto:{{ $user->email }}" class="pf-social-btn pf-email">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        {{ $user->email }}
                    </a>

                    {{-- LinkedIn --}}
                    @if($user->linkedin_url)
                    <a href="{{ $user->linkedin_url }}" target="_blank" rel="noopener" class="pf-social-btn pf-linkedin">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                        LinkedIn
                    </a>
                    @elseif(auth()->id() === $user->id)
                    <a href="{{ route('portfolio.edit') }}" class="pf-social-btn pf-empty-btn" title="Ajouter votre LinkedIn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                        LinkedIn <span class="pf-add-tag">+ Ajouter</span>
                    </a>
                    @endif

                    {{-- GitHub --}}
                    @if($user->github_url)
                    <a href="{{ $user->github_url }}" target="_blank" rel="noopener" class="pf-social-btn pf-github">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        GitHub
                    </a>
                    @elseif(auth()->id() === $user->id)
                    <a href="{{ route('portfolio.edit') }}" class="pf-social-btn pf-empty-btn" title="Ajouter votre GitHub">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        GitHub <span class="pf-add-tag">+ Ajouter</span>
                    </a>
                    @endif

                    {{-- CV — visible only to the owner and verified recruiters --}}
                    @php $canViewCv = $user->cvVisibleTo(auth()->user()); @endphp
                    @if($user->cv_path && $canViewCv)
                    <a href="{{ route('files.cv', $user) }}" target="_blank" class="pf-social-btn pf-cv">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        Télécharger CV
                    </a>
                    @elseif($user->cv_path)
                    <span class="pf-social-btn pf-cv-locked" title="Le CV est réservé aux recruteurs vérifiés">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        CV réservé aux recruteurs
                    </span>
                    @elseif(auth()->id() === $user->id)
                    <a href="{{ route('portfolio.edit') }}" class="pf-social-btn pf-empty-btn">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        CV <span class="pf-add-tag">+ Ajouter</span>
                    </a>
                    @endif
                </div>

                {{-- Friend request / Owner actions --}}
                <div style="display:flex;flex-wrap:wrap;gap:.6rem;margin-top:.5rem">
                    <a href="{{ route('portfolio.pdf', $user) }}" class="pf-friend-btn pf-friend-pdf">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9 15 12 18 15 15"/></svg>
                        CV PDF
                    </a>
                    @if(auth()->id() === $user->id)
                    <a href="{{ route('portfolio.edit') }}" class="pf-edit-hero-btn">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                        Compléter mon profil
                    </a>
                    <a href="{{ route('friends.requests') }}" class="pf-edit-hero-btn" style="background:rgba(99,102,241,.15);color:#a5b4fc;border-color:rgba(99,102,241,.3)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Mon réseau
                    </a>
                    @elseif(auth()->check())
                    <a href="{{ route('messages.show', $user) }}" class="pf-friend-btn pf-friend-msg">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        Message
                    </a>
                    @php $friendship = auth()->user()->friendshipWith($user->id); @endphp
                    @if(!$friendship)
                    <form action="{{ route('friends.send', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="pf-friend-btn pf-friend-send">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                            Demander en ami
                        </button>
                    </form>
                    @elseif($friendship->status === 'pending' && $friendship->requester_id === auth()->id())
                    <form action="{{ route('friends.cancel', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="pf-friend-btn pf-friend-pending">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                            Demande envoyée · Annuler
                        </button>
                    </form>
                    @elseif($friendship->status === 'pending' && $friendship->receiver_id === auth()->id())
                    <div style="display:flex;gap:.5rem">
                        <form action="{{ route('friends.accept', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="pf-friend-btn pf-friend-accept">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Accepter
                            </button>
                        </form>
                        <form action="{{ route('friends.reject', $user) }}" method="POST">
                            @csrf
                            <button type="submit" class="pf-friend-btn pf-friend-reject">Refuser</button>
                        </form>
                    </div>
                    @elseif($friendship->status === 'accepted')
                    <form action="{{ route('friends.unfriend', $user) }}" method="POST" onsubmit="return confirm('Retirer de vos amis ?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="pf-friend-btn pf-friend-friends">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Amis · Retirer
                        </button>
                    </form>
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="pf-body">
        <div class="pf-main">

            {{-- PROJECTS --}}
            <section class="pf-section">
                <div class="pf-section-header">
                    <div class="pf-section-icon" style="background:rgba(99,102,241,.12);color:#6366f1">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h1v6H9zM14 9h1v6h-1z"/></svg>
                    </div>
                    <h2 class="pf-section-title">Projets réalisés</h2>
                    @if($user->projects->isNotEmpty())
                    <span class="pf-section-count">{{ $user->projects->count() }}</span>
                    @endif
                    @if(auth()->id() === $user->id)
                    <a href="{{ route('portfolio.edit') }}" class="pf-section-add">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Ajouter
                    </a>
                    @endif
                </div>

                @if($user->projects->isNotEmpty())
                <div class="pf-projects-grid">
                    @foreach($user->projects as $project)
                    <div class="pf-project-card">
                        <div class="pf-project-top">
                            <span class="pf-project-type pf-type-{{ $project->type }}">
                                {{ ['academique'=>'Académique','personnel'=>'Personnel','stage'=>'Stage'][$project->type] ?? $project->type }}
                            </span>
                            @if($project->year)<span class="pf-project-year">{{ $project->year }}</span>@endif
                        </div>
                        <h3 class="pf-project-title">{{ $project->title }}</h3>
                        @if($project->description)
                        <p class="pf-project-desc">{{ $project->description }}</p>
                        @endif
                        @if($project->technologies)
                        <div class="pf-tech-tags">
                            @foreach($project->technologies as $tech)
                            <span class="pf-tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                        @endif
                        <div class="pf-project-links">
                            @if($project->github_url)
                            <a href="{{ $project->github_url }}" target="_blank" rel="noopener" class="pf-link-btn pf-link-github">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                                GitHub
                            </a>
                            @endif
                            @if($project->demo_url)
                            <a href="{{ $project->demo_url }}" target="_blank" rel="noopener" class="pf-link-btn pf-link-demo">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                                Démo
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="pf-empty-section">
                    <div class="pf-empty-icon" style="color:#6366f1">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M9 9h1v6H9zM14 9h1v6h-1z"/></svg>
                    </div>
                    @if(auth()->id() === $user->id)
                    <p class="pf-empty-text">Vous n'avez pas encore ajouté de projets.</p>
                    <a href="{{ route('portfolio.edit') }}" class="pf-empty-cta">Ajouter mon premier projet →</a>
                    @else
                    <p class="pf-empty-text">Aucun projet renseigné pour l'instant.</p>
                    @endif
                </div>
                @endif
            </section>

            {{-- INTERNSHIPS --}}
            <section class="pf-section">
                <div class="pf-section-header">
                    <div class="pf-section-icon" style="background:rgba(245,158,11,.12);color:#f59e0b">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                    <h2 class="pf-section-title">Stages effectués</h2>
                    @if($user->internships->isNotEmpty())
                    <span class="pf-section-count">{{ $user->internships->count() }}</span>
                    @endif
                    @if(auth()->id() === $user->id)
                    <a href="{{ route('portfolio.edit') }}" class="pf-section-add" style="color:#f59e0b;border-color:rgba(245,158,11,.25);background:rgba(245,158,11,.08)">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Ajouter
                    </a>
                    @endif
                </div>

                @if($user->internships->isNotEmpty())
                <div class="pf-timeline">
                    @foreach($user->internships as $internship)
                    <div class="pf-timeline-item">
                        <div class="pf-timeline-dot"></div>
                        <div class="pf-timeline-content">
                            <div class="pf-timeline-top">
                                <div>
                                    <h3 class="pf-timeline-title">{{ $internship->position }}</h3>
                                    <p class="pf-timeline-company">{{ $internship->company }}</p>
                                </div>
                                <div class="pf-timeline-right">
                                    <span class="pf-intern-type pf-itype-{{ $internship->type }}">
                                        {{ ['observation'=>'Observation','execution'=>'Exécution','pfe'=>'PFE'][$internship->type] ?? $internship->type }}
                                    </span>
                                    <span class="pf-timeline-period">{{ $internship->period }}</span>
                                </div>
                            </div>
                            @if($internship->description)
                            <p class="pf-timeline-desc">{{ $internship->description }}</p>
                            @endif
                            @if($internship->report_path)
                            <a href="{{ route('files.report', $internship) }}" target="_blank" class="pf-report-btn">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Voir le rapport PDF
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="pf-empty-section">
                    <div class="pf-empty-icon" style="color:#f59e0b">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                    @if(auth()->id() === $user->id)
                    <p class="pf-empty-text">Vous n'avez pas encore ajouté de stages.</p>
                    <a href="{{ route('portfolio.edit') }}" class="pf-empty-cta" style="color:#f59e0b;border-color:rgba(245,158,11,.3)">Ajouter mon premier stage →</a>
                    @else
                    <p class="pf-empty-text">Aucun stage renseigné pour l'instant.</p>
                    @endif
                </div>
                @endif
            </section>

            {{-- ARTICLES --}}
            @if($user->posts->isNotEmpty())
            <section class="pf-section">
                <div class="pf-section-header">
                    <div class="pf-section-icon" style="background:rgba(16,185,129,.12);color:#059669">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20l9-5-9-5-9 5 9 5z"/><polyline points="12 12 21 7 12 2 3 7 12 12"/></svg>
                    </div>
                    <h2 class="pf-section-title">Articles publiés</h2>
                    <span class="pf-section-count">{{ $user->posts()->count() }}</span>
                </div>
                <div class="pf-articles-list">
                    @foreach($user->posts as $post)
                    <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="pf-article-item">
                        <div class="pf-article-info">
                            <span class="pf-article-title">{{ $post->title }}</span>
                            <span class="pf-article-date">{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Articles repostés --}}
            @if($user->reposts->isNotEmpty())
            <section class="pf-section">
                <div class="pf-section-header">
                    <div class="pf-section-icon" style="background:rgba(14,165,233,.12);color:#0284c7">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                    </div>
                    <h2 class="pf-section-title">Articles repostés</h2>
                    <span class="pf-section-count">{{ $user->reposts->count() }}</span>
                </div>
                <div class="pf-articles-list">
                    @foreach($user->reposts as $post)
                    <a href="{{ route('posts.show', $post->slug ?? $post->id) }}" class="pf-article-item">
                        <div class="pf-article-info">
                            <span class="pf-article-title">{{ $post->title }}</span>
                            <span class="pf-article-date">Reposté @if($post->user)· par {{ $post->user->name }}@endif</span>
                        </div>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    @endforeach
                </div>
            </section>
            @endif

        </div>

        {{-- SIDEBAR --}}
        <aside class="pf-sidebar">
            <div class="pf-sidebar-card">
                <h4 class="pf-sidebar-title">Infos</h4>
                <ul class="pf-info-list">
                    @if($user->filiere)
                    <li><span class="pf-info-label">Filière</span><span class="pf-info-val">{{ $user->filiere }}</span></li>
                    @endif
                    @if($user->promotion)
                    <li><span class="pf-info-label">Promotion</span><span class="pf-info-val">{{ $user->promotion }}</span></li>
                    @endif
                    @if($user->phone)
                    @php
                        $showPhone = false;
                        if($user->phone_privacy === 'public') $showPhone = true;
                        elseif($user->phone_privacy === 'friends' && auth()->check() && auth()->user()->isFriendWith($user->id)) $showPhone = true;
                        elseif(auth()->id() === $user->id) $showPhone = true;
                    @endphp
                    @if($showPhone)
                    <li>
                        <span class="pf-info-label">Téléphone</span>
                        <span class="pf-info-val">{{ $user->phone }}</span>
                    </li>
                    @elseif($user->phone_privacy === 'friends')
                    <li>
                        <span class="pf-info-label">Téléphone</span>
                        <span class="pf-info-val pf-private-val">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Amis seulement
                        </span>
                    </li>
                    @elseif($user->phone_privacy === 'private')
                    <li>
                        <span class="pf-info-label">Téléphone</span>
                        <span class="pf-info-val pf-private-val">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            Privé
                        </span>
                    </li>
                    @endif
                    @endif
                    <li><span class="pf-info-label">Articles</span><span class="pf-info-val">{{ $user->posts()->count() }}</span></li>
                    <li>
                        <span class="pf-info-label">Projets</span>
                        <span class="pf-info-val" style="{{ $user->projects->isEmpty() ? 'color:var(--text-muted);font-weight:500' : '' }}">
                            {{ $user->projects->count() ?: '—' }}
                        </span>
                    </li>
                    <li>
                        <span class="pf-info-label">Stages</span>
                        <span class="pf-info-val" style="{{ $user->internships->isEmpty() ? 'color:var(--text-muted);font-weight:500' : '' }}">
                            {{ $user->internships->count() ?: '—' }}
                        </span>
                    </li>
                </ul>
            </div>

            {{-- Contacts card --}}
            <div class="pf-sidebar-card">
                <h4 class="pf-sidebar-title">Contact & Réseaux</h4>
                <div class="pf-contact-list">
                    <a href="mailto:{{ $user->email }}" class="pf-contact-item">
                        <span class="pf-contact-icon" style="background:rgba(15,23,42,.07)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </span>
                        <span class="pf-contact-label">Email</span>
                    </a>
                    @if($user->linkedin_url)
                    <a href="{{ $user->linkedin_url }}" target="_blank" rel="noopener" class="pf-contact-item">
                        <span class="pf-contact-icon" style="background:#0077b5;color:white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                        </span>
                        <span class="pf-contact-label">LinkedIn</span>
                    </a>
                    @else
                    <div class="pf-contact-item pf-contact-empty">
                        <span class="pf-contact-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" opacity=".3"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                        </span>
                        <span class="pf-contact-label" style="opacity:.4">LinkedIn non renseigné</span>
                    </div>
                    @endif
                    @if($user->github_url)
                    <a href="{{ $user->github_url }}" target="_blank" rel="noopener" class="pf-contact-item">
                        <span class="pf-contact-icon" style="background:#24292e;color:white">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        </span>
                        <span class="pf-contact-label">GitHub</span>
                    </a>
                    @else
                    <div class="pf-contact-item pf-contact-empty">
                        <span class="pf-contact-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" opacity=".3"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"/></svg>
                        </span>
                        <span class="pf-contact-label" style="opacity:.4">GitHub non renseigné</span>
                    </div>
                    @endif
                    @if($user->cv_path && $canViewCv)
                    <a href="{{ route('files.cv', $user) }}" target="_blank" class="pf-contact-item">
                        <span class="pf-contact-icon" style="background:linear-gradient(135deg,#6EE7B7,#34d399);color:#0f172a">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </span>
                        <span class="pf-contact-label">Télécharger CV</span>
                    </a>
                    @elseif($user->cv_path)
                    <div class="pf-contact-item pf-contact-empty" title="Réservé aux recruteurs vérifiés">
                        <span class="pf-contact-icon" style="background:rgba(99,102,241,.1);color:#6366f1">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <span class="pf-contact-label" style="font-size:.78rem">CV réservé aux recruteurs</span>
                    </div>
                    @else
                    <div class="pf-contact-item pf-contact-empty">
                        <span class="pf-contact-icon">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" opacity=".3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </span>
                        <span class="pf-contact-label" style="opacity:.4">CV non renseigné</span>
                    </div>
                    @endif
                </div>
            </div>

            @if(auth()->id() === $user->id)
            <a href="{{ route('portfolio.edit') }}" class="pf-edit-btn">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                Modifier mon portfolio
            </a>
            @endif
        </aside>
    </div>
</div>

<style>
.pf-page { max-width: 1100px; margin: 0 auto; padding: 0 1.5rem 4rem; }

/* HERO */
.pf-hero {
    position: relative; border-radius: 0 0 28px 28px; overflow: hidden;
    padding: 3rem 2.5rem 2.5rem; margin: 0 -1.5rem 2.5rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #134e4a 100%);
    color: white;
}
.pf-hero-bg {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 30%, rgba(110,231,183,.15) 0%, transparent 55%),
                radial-gradient(ellipse at 15% 70%, rgba(99,102,241,.1) 0%, transparent 50%);
    pointer-events: none;
}
.pf-hero-inner { position: relative; z-index: 1; display: flex; align-items: flex-start; gap: 2rem; flex-wrap: wrap; }

.pf-avatar-wrap { flex-shrink: 0; }
.pf-avatar { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(110,231,183,.5); }
.pf-avatar-initials {
    width: 100px; height: 100px; border-radius: 50%;
    background: linear-gradient(135deg, #6EE7B7, #34d399);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; font-weight: 800; color: #0f172a;
    border: 3px solid rgba(110,231,183,.4);
}
.pf-badge { display: inline-block; background: rgba(110,231,183,.15); color: #6EE7B7; border: 1px solid rgba(110,231,183,.3); padding: 3px 14px; border-radius: 999px; font-size: .72rem; font-weight: 700; letter-spacing: .06em; text-transform: uppercase; margin-bottom: .75rem; }
.pf-name { font-size: clamp(1.6rem, 4vw, 2.5rem); font-weight: 800; color: white; letter-spacing: -.03em; margin: 0 0 .25rem; }
.pf-filiere { font-size: .9rem; color: #6EE7B7; font-weight: 600; margin: 0 0 .75rem; }
.pf-bio { font-size: .9rem; color: rgba(255,255,255,.65); line-height: 1.65; max-width: 520px; margin: 0 0 1.25rem; }

.pf-socials { display: flex; flex-wrap: wrap; gap: .55rem; margin-bottom: .9rem; }
.pf-social-btn { display: inline-flex; align-items: center; gap: 7px; padding: 7px 15px; border-radius: 10px; font-size: .8rem; font-weight: 600; text-decoration: none; transition: opacity .2s, transform .2s; }
.pf-social-btn:hover { opacity: .85; transform: translateY(-1px); }
.pf-email    { background: rgba(255,255,255,.12); color: white; border: 1px solid rgba(255,255,255,.2); }
.pf-linkedin { background: #0077b5; color: white; }
.pf-github   { background: rgba(255,255,255,.15); color: white; border: 1px solid rgba(255,255,255,.2); }
.pf-cv       { background: linear-gradient(135deg,#6EE7B7,#34d399); color: #0f172a; }
.pf-cv-locked { background: rgba(99,102,241,.15); color: #c7d2fe; border: 1px solid rgba(99,102,241,.3); cursor: not-allowed; }
.pf-empty-btn { background: rgba(255,255,255,.06); color: rgba(255,255,255,.45); border: 1px dashed rgba(255,255,255,.2); cursor: pointer; }
.pf-empty-btn:hover { opacity: 1; background: rgba(255,255,255,.1); border-style: solid; color: white; }
.pf-add-tag { font-size: .7rem; background: rgba(110,231,183,.2); color: #6EE7B7; padding: 1px 7px; border-radius: 999px; font-weight: 700; }

.pf-edit-hero-btn { display: inline-flex; align-items: center; gap: 7px; padding: 6px 14px; background: rgba(110,231,183,.15); color: #6EE7B7; border: 1px solid rgba(110,231,183,.3); border-radius: 10px; font-size: .78rem; font-weight: 700; text-decoration: none; transition: background .18s; }
.pf-edit-hero-btn:hover { background: rgba(110,231,183,.25); }

/* BODY LAYOUT */
.pf-body { display: grid; grid-template-columns: 1fr 260px; gap: 2rem; align-items: start; }
@media(max-width:768px){ .pf-body { grid-template-columns: 1fr; } }

/* SECTIONS */
.pf-section { margin-bottom: 2rem; }
.pf-section-header { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.1rem; }
.pf-section-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.pf-section-title { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); flex: 1; }
.pf-section-count { background: rgba(15,23,42,.07); color: var(--text-muted); border-radius: 999px; padding: 2px 10px; font-size: .75rem; font-weight: 700; }
.pf-section-add { display: inline-flex; align-items: center; gap: 5px; font-size: .75rem; font-weight: 700; color: var(--success); background: rgba(110,231,183,.1); border: 1px solid rgba(110,231,183,.25); padding: 4px 12px; border-radius: 999px; text-decoration: none; transition: background .18s; }
.pf-section-add:hover { background: rgba(110,231,183,.2); }

/* EMPTY STATES */
.pf-empty-section { display: flex; flex-direction: column; align-items: center; gap: .75rem; padding: 2.5rem 1rem; background: rgba(255,255,255,.5); border: 1.5px dashed var(--border-color); border-radius: 16px; text-align: center; }
.pf-empty-icon { opacity: .5; }
.pf-empty-text { font-size: .88rem; color: var(--text-muted); margin: 0; }
.pf-empty-cta { font-size: .82rem; font-weight: 700; color: var(--success); text-decoration: none; border-bottom: 1px solid rgba(110,231,183,.4); padding-bottom: 1px; transition: border-color .18s; }
.pf-empty-cta:hover { border-bottom-color: var(--success); }

/* PROJECTS GRID */
.pf-projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1rem; }
.pf-project-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.25rem; display: flex; flex-direction: column; gap: .7rem; transition: transform .2s, box-shadow .2s; }
.pf-project-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }
.pf-project-top { display: flex; align-items: center; justify-content: space-between; }
.pf-project-type { font-size: .7rem; font-weight: 700; padding: 3px 10px; border-radius: 999px; }
.pf-type-academique { background: rgba(99,102,241,.1); color: #6366f1; }
.pf-type-personnel  { background: rgba(16,185,129,.1); color: #059669; }
.pf-type-stage      { background: rgba(245,158,11,.1); color: #d97706; }
.pf-project-year { font-size: .78rem; color: var(--text-muted); font-weight: 600; }
.pf-project-title { font-size: .95rem; font-weight: 700; color: var(--text-primary); margin: 0; }
.pf-project-desc { font-size: .83rem; color: var(--text-muted); line-height: 1.55; margin: 0; flex: 1; }
.pf-tech-tags { display: flex; flex-wrap: wrap; gap: 5px; }
.pf-tech-tag { background: rgba(15,23,42,.06); color: var(--text-muted); font-size: .7rem; font-weight: 600; padding: 2px 8px; border-radius: 6px; border: 1px solid var(--border-color); }
.pf-project-links { display: flex; gap: .5rem; padding-top: .5rem; border-top: 1px solid var(--border-color); }
.pf-link-btn { display: inline-flex; align-items: center; gap: 5px; font-size: .75rem; font-weight: 700; padding: 5px 11px; border-radius: 8px; text-decoration: none; transition: opacity .2s; }
.pf-link-btn:hover { opacity: .8; }
.pf-link-github { background: #24292e; color: white; }
.pf-link-demo   { background: var(--gradient-primary); color: #0f172a; }

/* TIMELINE */
.pf-timeline { display: flex; flex-direction: column; position: relative; padding-left: 1.5rem; }
.pf-timeline::before { content:''; position: absolute; left: 7px; top: 8px; bottom: 8px; width: 2px; background: linear-gradient(to bottom, #6EE7B7, rgba(110,231,183,.15)); border-radius: 2px; }
.pf-timeline-item { position: relative; padding-bottom: 1.25rem; }
.pf-timeline-dot { position: absolute; left: -1.5rem; top: 6px; width: 14px; height: 14px; border-radius: 50%; background: #6EE7B7; border: 3px solid white; box-shadow: 0 0 0 2px rgba(110,231,183,.3); }
.pf-timeline-content { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 14px; padding: 1rem 1.25rem; }
.pf-timeline-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: .5rem; flex-wrap: wrap; }
.pf-timeline-title { font-size: .95rem; font-weight: 700; color: var(--text-primary); margin: 0 0 2px; }
.pf-timeline-company { font-size: .83rem; color: var(--text-muted); margin: 0; }
.pf-timeline-right { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; flex-shrink: 0; }
.pf-timeline-period { font-size: .75rem; color: var(--text-muted); font-weight: 600; }
.pf-intern-type { font-size: .68rem; font-weight: 700; padding: 2px 9px; border-radius: 999px; }
.pf-itype-observation { background: rgba(99,102,241,.1); color: #6366f1; }
.pf-itype-execution   { background: rgba(245,158,11,.1); color: #d97706; }
.pf-itype-pfe         { background: rgba(239,68,68,.1); color: #dc2626; }
.pf-timeline-desc { font-size: .83rem; color: var(--text-muted); line-height: 1.6; margin: .5rem 0 0; }
.pf-report-btn { display: inline-flex; align-items: center; gap: 6px; margin-top: .75rem; font-size: .78rem; font-weight: 700; color: #dc2626; text-decoration: none; padding: 5px 12px; background: rgba(239,68,68,.08); border-radius: 8px; border: 1px solid rgba(239,68,68,.2); transition: opacity .2s; }
.pf-report-btn:hover { opacity: .8; }

/* ARTICLES */
.pf-articles-list { display: flex; flex-direction: column; gap: .55rem; }
.pf-article-item { display: flex; align-items: center; justify-content: space-between; padding: .85rem 1rem; background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 12px; text-decoration: none; color: inherit; transition: transform .18s, border-color .18s; }
.pf-article-item:hover { transform: translateX(4px); border-color: rgba(110,231,183,.4); }
.pf-article-info { display: flex; flex-direction: column; gap: 3px; }
.pf-article-title { font-size: .88rem; font-weight: 700; color: var(--text-primary); }
.pf-article-date { font-size: .73rem; color: var(--text-muted); }

/* SIDEBAR */
.pf-sidebar-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 18px; padding: 1.25rem; margin-bottom: 1rem; }
.pf-sidebar-title { font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em; color: var(--text-muted); margin-bottom: 1rem; }
.pf-info-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: .55rem; }
.pf-info-list li { display: flex; justify-content: space-between; align-items: center; font-size: .83rem; }
.pf-info-label { color: var(--text-muted); }
.pf-info-val { font-weight: 700; color: var(--text-primary); text-align: right; max-width: 60%; }

.pf-contact-list { display: flex; flex-direction: column; gap: .5rem; }
.pf-contact-item { display: flex; align-items: center; gap: .75rem; padding: .55rem .7rem; border-radius: 10px; text-decoration: none; color: var(--text-primary); transition: background .18s; }
.pf-contact-item:hover:not(.pf-contact-empty) { background: rgba(15,23,42,.04); }
.pf-contact-empty { cursor: default; }
.pf-contact-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; background: rgba(15,23,42,.07); color: var(--text-primary); }
.pf-contact-label { font-size: .82rem; font-weight: 600; }

.pf-edit-btn { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 11px; background: var(--gradient-primary); color: #0f172a; border-radius: 12px; font-weight: 700; font-size: .85rem; text-decoration: none; transition: opacity .2s; }
.pf-edit-btn:hover { opacity: .88; }

/* Friend buttons */
.pf-friend-btn { display: inline-flex; align-items: center; gap: 7px; padding: 7px 16px; border-radius: 10px; font-size: .8rem; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: opacity .2s, transform .18s; }
.pf-friend-btn:hover { opacity: .85; transform: translateY(-1px); }
.pf-friend-send    { background: linear-gradient(135deg,#818cf8,#6366f1); color: white; }
.pf-friend-msg     { background: rgba(255,255,255,.12); color: #fff; border: 1px solid rgba(255,255,255,.25); text-decoration: none; }
.pf-friend-msg:hover { background: rgba(255,255,255,.2); }
.pf-friend-pdf     { background: rgba(110,231,183,.18); color: #6EE7B7; border: 1px solid rgba(110,231,183,.35); text-decoration: none; }
.pf-friend-pdf:hover { background: rgba(110,231,183,.28); }
.pf-friend-pending { background: rgba(255,255,255,.12); color: rgba(255,255,255,.6); border: 1px dashed rgba(255,255,255,.25); }
.pf-friend-pending:hover { background: rgba(239,68,68,.15); color: #fca5a5; border-color: rgba(239,68,68,.3); }
.pf-friend-accept  { background: linear-gradient(135deg,#6EE7B7,#34d399); color: #0f172a; }
.pf-friend-reject  { background: rgba(255,255,255,.1); color: rgba(255,255,255,.5); border: 1px solid rgba(255,255,255,.15); }
.pf-friend-friends { background: rgba(110,231,183,.15); color: #6EE7B7; border: 1px solid rgba(110,231,183,.3); }
.pf-friend-friends:hover { background: rgba(239,68,68,.15); color: #fca5a5; border-color: rgba(239,68,68,.3); }

/* Privacy */
.pf-private-val { display: inline-flex; align-items: center; gap: 5px; color: var(--text-muted) !important; font-weight: 500 !important; font-size: .78rem; opacity: .7; }
</style>
@endsection
