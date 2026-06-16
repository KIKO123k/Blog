@extends('layouts.app')

@section('title', $club->name . ' — Clubs ENSA Kénitra')

@section('content')
<div class="club-show-page">

    {{-- HERO --}}
    <div class="club-show-hero" data-theme="{{ $club->theme }}">
        <div class="club-show-hero-bg"></div>
        <div class="club-show-hero-content">
            <a href="{{ route('clubs.index') }}" class="club-show-back">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Tous les clubs
            </a>

            <div class="club-show-top">
                <div class="club-show-icon-wrap">
                    @php
                        $icons = [
                            'code'       => '<path d="M16 18l6-6-6-6"/><path d="M8 6l-6 6 6 6"/>',
                            'robotics'   => '<rect x="3" y="11" width="18" height="10" rx="2"/><path d="M12 11V5"/><circle cx="12" cy="3" r="2"/>',
                            'ai'         => '<circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/>',
                            'cyber'      => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>',
                            'network'    => '<circle cx="12" cy="5" r="3"/><circle cx="5" cy="19" r="3"/><circle cx="19" cy="19" r="3"/><path d="M12 8v3M9.7 16.5L7 17.5M14.3 16.5L17 17.5"/>',
                            'industrial' => '<circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4"/>',
                            'management' => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
                            'leadership' => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
                            'social'     => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
                        ];
                    @endphp
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        {!! $icons[$club->theme] ?? $icons['code'] !!}
                    </svg>
                </div>
                <div>
                    <span class="club-show-acronym">{{ $club->acronym }}</span>
                    <h1 class="club-show-name">{{ $club->name }}</h1>
                </div>
            </div>

            <p class="club-show-tagline">{{ $club->description }}</p>

            {{-- SOCIAL BUTTONS --}}
            <div class="club-show-socials">
                @if($club->instagram_url)
                <a href="{{ $club->instagram_url }}" target="_blank" rel="noopener noreferrer" class="club-social-btn instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    Instagram
                </a>
                @endif
                @if($club->linkedin_url)
                <a href="{{ $club->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="club-social-btn linkedin">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                    </svg>
                    LinkedIn
                </a>
                @endif
                @if($club->facebook_url)
                <a href="{{ $club->facebook_url }}" target="_blank" rel="noopener noreferrer" class="club-social-btn facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    Facebook
                </a>
                @endif
                @if($club->website_url)
                <a href="{{ $club->website_url }}" target="_blank" rel="noopener noreferrer" class="club-social-btn website">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                    </svg>
                    Site Web
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="club-show-layout">

        {{-- LEFT --}}
        <div class="club-show-main">

            {{-- About --}}
            <div class="club-show-card">
                <div class="club-show-card-header">
                    <div class="csc-icon" style="background:rgba(59,130,246,0.1);color:#2563eb;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    </div>
                    <h2>À propos</h2>
                </div>
                <p class="club-show-about">{{ $club->long_description ?? $club->description }}</p>
            </div>

            {{-- Activities --}}
            @if(!empty($club->activities))
            <div class="club-show-card">
                <div class="club-show-card-header">
                    <div class="csc-icon" style="background:rgba(16,185,129,0.1);color:#059669;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <h2>Activités & Projets</h2>
                </div>
                <ul class="club-show-activities">
                    @foreach($club->activities as $activity)
                    <li>
                        <span class="csa-check">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        {{ $activity }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Événements à venir --}}
            @if(isset($events) && $events->isNotEmpty())
            <div class="club-show-card">
                <div class="club-show-card-header">
                    <div class="csc-icon" style="background:rgba(245,158,11,0.1);color:#d97706;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <h2>Événements à venir</h2>
                    <a href="{{ route('events.index') }}" class="club-members-count" style="text-decoration:none;">Agenda complet →</a>
                </div>
                <div class="club-events-list">
                    @foreach($events as $event)
                    <div class="club-event-row">
                        <div class="cev-date">
                            <span class="cev-day">{{ $event->starts_at->format('d') }}</span>
                            <span class="cev-mon">{{ ucfirst($event->starts_at->translatedFormat('M')) }}</span>
                        </div>
                        <div class="cev-info">
                            <span class="cev-title">{{ $event->title }}</span>
                            <span class="cev-meta">{{ $event->starts_at->format('H:i') }}@if($event->location) · {{ $event->location }}@endif · {{ $event->participants_count }} inscrit(s)</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Bureau du club --}}
            @if($bureau->isNotEmpty())
            <div class="club-show-card">
                <div class="club-show-card-header">
                    <div class="csc-icon" style="background:rgba(99,102,241,0.1);color:#6366f1;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    </div>
                    <h2>Bureau du club</h2>
                </div>
                <p class="club-members-hint">Cliquez sur un membre pour découvrir son portfolio.</p>
                <div class="club-bureau-grid">
                    @foreach($bureau as $m)
                    @php
                        $w = preg_split('/\s+/', trim($m->name));
                        $ini = strtoupper(mb_substr($w[0], 0, 1) . (isset($w[1]) ? mb_substr($w[1], 0, 1) : ''));
                    @endphp
                    <a href="{{ route('portfolio.show', $m) }}" class="club-bureau-card">
                        @if($m->avatar_path)
                            <img src="{{ Storage::url($m->avatar_path) }}" alt="{{ $m->name }}" class="cbm-avatar-img">
                        @else
                            <span class="cbm-avatar">{{ $ini }}</span>
                        @endif
                        <span class="cbm-info">
                            <span class="cbm-role">{{ $m->pivot->role }}</span>
                            <span class="cbm-name">{{ $m->name }}</span>
                            <span class="cbm-email">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                {{ $m->email }}
                            </span>
                        </span>
                        <svg class="cbm-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Membres adhérents --}}
            @if($adherents->isNotEmpty())
            <div class="club-show-card">
                <div class="club-show-card-header">
                    <div class="csc-icon" style="background:rgba(16,185,129,0.1);color:#059669;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h2>Membres adhérents</h2>
                    <span class="club-members-count">{{ $adherents->count() }}</span>
                </div>
                <div class="club-adherents-grid">
                    @foreach($adherents as $m)
                    @php
                        $w = preg_split('/\s+/', trim($m->name));
                        $ini = strtoupper(mb_substr($w[0], 0, 1) . (isset($w[1]) ? mb_substr($w[1], 0, 1) : ''));
                    @endphp
                    <a href="{{ route('portfolio.show', $m) }}" class="club-adherent-chip">
                        @if($m->avatar_path)
                            <img src="{{ Storage::url($m->avatar_path) }}" alt="{{ $m->name }}" class="cma-avatar-img">
                        @else
                            <span class="cma-avatar">{{ $ini }}</span>
                        @endif
                        <span class="cma-text">
                            <span class="cma-name">{{ $m->name }}</span>
                            <span class="cma-filiere">{{ $m->filiere ?? 'Étudiant ENSA' }}</span>
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Call to action --}}
            <div class="club-show-cta">
                <div>
                    <h3>Rejoindre le club ?</h3>
                    <p>Contactez-nous via nos réseaux sociaux ou passez directement au bureau de l'ADE ENSAK.</p>
                </div>
                @if($club->instagram_url)
                <a href="{{ $club->instagram_url }}" target="_blank" rel="noopener noreferrer" class="club-cta-btn">
                    Nous contacter
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                @elseif($club->linkedin_url)
                <a href="{{ $club->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="club-cta-btn">
                    Nous contacter
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                </a>
                @endif
            </div>
        </div>

        {{-- SIDEBAR --}}
        <aside class="club-show-sidebar">

            {{-- Info card --}}
            <div class="club-show-info-card">
                <h3>Informations</h3>
                <ul class="club-info-list">
                    @if($club->founded_year)
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <div>
                            <span>Fondé en</span>
                            <strong>{{ $club->founded_year }}</strong>
                        </div>
                    </li>
                    @endif
                    @if($club->members_count)
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <div>
                            <span>Membres</span>
                            <strong>+{{ $club->members_count }}</strong>
                        </div>
                    </li>
                    @endif
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                        <div>
                            <span>Domaine</span>
                            <strong>{{ ucfirst($club->theme) }}</strong>
                        </div>
                    </li>
                    @if($club->president)
                    <li>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <div>
                            <span>Président(e)</span>
                            <strong>{{ $club->president }}</strong>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Social links sidebar --}}
            @if($club->instagram_url || $club->linkedin_url || $club->facebook_url || $club->website_url)
            <div class="club-show-info-card">
                <h3>Nous suivre</h3>
                <div class="club-sidebar-socials">
                    @if($club->instagram_url)
                    <a href="{{ $club->instagram_url }}" target="_blank" rel="noopener noreferrer" class="club-sidebar-social instagram">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <span>{{ '@' . basename(rtrim($club->instagram_url, '/')) }}</span>
                    </a>
                    @endif
                    @if($club->linkedin_url)
                    <a href="{{ $club->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="club-sidebar-social linkedin">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        <span>LinkedIn</span>
                    </a>
                    @endif
                    @if($club->facebook_url)
                    <a href="{{ $club->facebook_url }}" target="_blank" rel="noopener noreferrer" class="club-sidebar-social facebook">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        <span>Facebook</span>
                    </a>
                    @endif
                    @if($club->website_url)
                    <a href="{{ $club->website_url }}" target="_blank" rel="noopener noreferrer" class="club-sidebar-social website">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        <span>Site officiel</span>
                    </a>
                    @endif
                </div>
            </div>
            @endif

            {{-- Other clubs --}}
            <div class="club-show-info-card">
                <h3>Autres clubs</h3>
                <div class="club-other-list">
                    @foreach(\App\Models\Club::where('id', '!=', $club->id)->limit(4)->get() as $other)
                    <a href="{{ route('clubs.show', $other) }}" class="club-other-item">
                        <span class="club-other-acronym">{{ $other->acronym }}</span>
                        <span class="club-other-name">{{ $other->name }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

        </aside>
    </div>
</div>

<style>
.club-show-page { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem 4rem; }

/* HERO */
.club-show-hero {
    position: relative;
    border-radius: 0 0 32px 32px;
    overflow: hidden;
    padding: 2.5rem 2.5rem 2rem;
    margin: 0 -1.5rem 2.5rem;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #134e4a 100%);
    color: white;
}
.club-show-hero-bg {
    position: absolute; inset: 0;
    background: radial-gradient(ellipse at 80% 20%, rgba(110,231,183,0.15) 0%, transparent 55%),
                radial-gradient(ellipse at 10% 80%, rgba(99,102,241,0.1) 0%, transparent 50%);
    pointer-events: none;
}
.club-show-hero-content { position: relative; z-index: 1; max-width: 800px; }
.club-show-back {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 0.85rem; color: rgba(255,255,255,0.55);
    margin-bottom: 1.5rem; transition: color 0.2s;
}
.club-show-back:hover { color: var(--primary); }
.club-show-top { display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1rem; }
.club-show-icon-wrap {
    width: 64px; height: 64px; border-radius: 18px;
    background: rgba(255,255,255,0.12);
    display: flex; align-items: center; justify-content: center;
    color: white; flex-shrink: 0;
    border: 1px solid rgba(255,255,255,0.15);
}
.club-show-acronym {
    font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em;
    color: var(--primary); text-transform: uppercase;
    background: rgba(110,231,183,0.12);
    border: 1px solid rgba(110,231,183,0.25);
    padding: 3px 10px; border-radius: 6px; display: inline-block; margin-bottom: 6px;
}
.club-show-name {
    font-size: clamp(1.5rem, 3.5vw, 2.2rem);
    font-family: var(--font-heading); font-weight: 800;
    color: white; line-height: 1.2; letter-spacing: -0.02em;
}
.club-show-tagline { font-size: 0.95rem; color: rgba(255,255,255,0.65); line-height: 1.7; margin-bottom: 1.75rem; max-width: 640px; }

/* SOCIAL BUTTONS */
.club-show-socials { display: flex; flex-wrap: wrap; gap: 10px; }
.club-social-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 9px 18px; border-radius: 10px;
    font-size: 0.85rem; font-weight: 600;
    transition: opacity 0.2s, transform 0.2s;
    text-decoration: none;
}
.club-social-btn:hover { opacity: 0.88; transform: translateY(-2px); }
.club-social-btn.instagram { background: linear-gradient(45deg,#f09433,#e6683c,#dc2743,#cc2366,#bc1888); color: white; }
.club-social-btn.linkedin  { background: #0077b5; color: white; }
.club-social-btn.facebook  { background: #1877f2; color: white; }
.club-social-btn.website   { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.2); }

/* LAYOUT */
.club-show-layout { display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start; }
@media (max-width: 860px) { .club-show-layout { grid-template-columns: 1fr; } }

/* CARDS */
.club-show-card {
    background: rgba(255,255,255,0.78);
    border: 1px solid var(--border-color);
    border-radius: 20px; padding: 1.5rem;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow-md);
}
.club-show-card-header { display: flex; align-items: center; gap: 10px; margin-bottom: 1rem; }
.csc-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.club-show-card-header h2 { font-size: 1.05rem; font-weight: 700; font-family: var(--font-heading); color: var(--text-primary); }
.club-show-about { font-size: 0.95rem; color: var(--text-secondary); line-height: 1.75; }

/* ACTIVITIES */
.club-show-activities { list-style: none; display: flex; flex-direction: column; gap: 10px; }
.club-show-activities li { display: flex; align-items: center; gap: 10px; font-size: 0.92rem; color: var(--text-secondary); }
.csa-check { width: 22px; height: 22px; background: rgba(16,185,129,0.1); color: #059669; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

/* CTA */
.club-show-cta {
    background: linear-gradient(135deg, rgba(110,231,183,0.12), rgba(52,211,153,0.06));
    border: 1px solid rgba(110,231,183,0.3);
    border-radius: 20px; padding: 1.5rem;
    display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
}
.club-show-cta h3 { font-size: 1rem; font-weight: 700; font-family: var(--font-heading); color: var(--text-primary); margin-bottom: 4px; }
.club-show-cta p { font-size: 0.85rem; color: var(--text-muted); }
.club-cta-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 22px; background: var(--gradient-primary);
    color: #0f172a; border-radius: 10px;
    font-weight: 700; font-size: 0.88rem;
    transition: opacity 0.2s; white-space: nowrap;
}
.club-cta-btn:hover { opacity: 0.85; }

/* SIDEBAR CARDS */
.club-show-info-card {
    background: rgba(255,255,255,0.8);
    border: 1px solid var(--border-color);
    border-radius: 20px; padding: 1.25rem;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(12px);
    box-shadow: var(--shadow-sm);
}
.club-show-info-card h3 { font-size: 0.9rem; font-weight: 700; font-family: var(--font-heading); color: var(--text-primary); margin-bottom: 1rem; }

/* Info list */
.club-info-list { list-style: none; display: flex; flex-direction: column; gap: 12px; }
.club-info-list li { display: flex; align-items: center; gap: 10px; color: var(--text-muted); }
.club-info-list li svg { flex-shrink: 0; }
.club-info-list div { display: flex; flex-direction: column; }
.club-info-list span { font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.04em; }
.club-info-list strong { font-size: 0.9rem; color: var(--text-primary); }

/* Sidebar socials */
.club-sidebar-socials { display: flex; flex-direction: column; gap: 8px; }
.club-sidebar-social {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 12px;
    font-size: 0.85rem; font-weight: 600;
    border: 1px solid var(--border-color);
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none;
}
.club-sidebar-social:hover { transform: translateX(3px); box-shadow: var(--shadow-sm); }
.club-sidebar-social.instagram { color: #e1306c; background: rgba(225,48,108,0.06); border-color: rgba(225,48,108,0.15); }
.club-sidebar-social.linkedin  { color: #0077b5; background: rgba(0,119,181,0.06); border-color: rgba(0,119,181,0.15); }
.club-sidebar-social.facebook  { color: #1877f2; background: rgba(24,119,242,0.06); border-color: rgba(24,119,242,0.15); }
.club-sidebar-social.website   { color: var(--success); background: var(--success-bg); border-color: rgba(110,231,183,0.25); }
.club-sidebar-social span { font-size: 0.82rem; }

/* Other clubs */
.club-other-list { display: flex; flex-direction: column; gap: 6px; }
.club-other-item {
    display: flex; align-items: center; gap: 10px;
    padding: 8px 10px; border-radius: 10px;
    border: 1px solid var(--border-color);
    transition: background 0.2s, border-color 0.2s;
    text-decoration: none;
}
.club-other-item:hover { background: var(--primary-glow); border-color: rgba(110,231,183,0.35); }
.club-other-acronym { font-size: 0.7rem; font-weight: 700; background: rgba(15,23,42,0.06); padding: 2px 7px; border-radius: 5px; color: var(--text-muted); white-space: nowrap; }
.club-other-name { font-size: 0.82rem; color: var(--text-secondary); font-weight: 500; line-height: 1.3; }

/* ===== MEMBRES ===== */
.club-members-hint { font-size: 0.82rem; color: var(--text-muted); margin: -0.25rem 0 1rem; }
.club-members-count { margin-left: auto; font-size: 0.78rem; font-weight: 700; color: var(--text-muted); background: rgba(15,23,42,0.06); padding: 3px 11px; border-radius: 999px; }

/* Bureau */
.club-bureau-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 0.85rem; }
.club-bureau-card {
    display: flex; align-items: center; gap: 12px;
    padding: 0.85rem 1rem; border-radius: 14px;
    border: 1px solid var(--border-color); background: rgba(255,255,255,0.6);
    text-decoration: none; transition: transform 0.18s, box-shadow 0.18s, border-color 0.18s;
}
.club-bureau-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: rgba(99,102,241,0.4); }
.cbm-avatar, .cbm-avatar-img { width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0; }
.cbm-avatar { display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; color: #fff; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.cbm-avatar-img { object-fit: cover; }
.cbm-info { display: flex; flex-direction: column; gap: 1px; min-width: 0; flex: 1; }
.cbm-role { font-size: 0.7rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; color: #6366f1; }
.cbm-name { font-size: 0.95rem; font-weight: 700; color: var(--text-primary); }
.cbm-email { display: flex; align-items: center; gap: 5px; font-size: 0.76rem; color: var(--text-muted); margin-top: 1px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
.cbm-email svg { flex-shrink: 0; opacity: 0.7; }
.cbm-arrow { color: var(--text-muted); opacity: 0; transform: translateX(-4px); transition: opacity 0.18s, transform 0.18s; flex-shrink: 0; }
.club-bureau-card:hover .cbm-arrow { opacity: 1; transform: translateX(0); color: #6366f1; }

/* Adhérents */
.club-adherents-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.6rem; }
.club-adherent-chip {
    display: flex; align-items: center; gap: 10px;
    padding: 0.6rem 0.75rem; border-radius: 12px;
    border: 1px solid var(--border-color); background: rgba(255,255,255,0.55);
    text-decoration: none; transition: transform 0.18s, border-color 0.18s, background 0.18s;
}
.club-adherent-chip:hover { transform: translateY(-2px); border-color: rgba(16,185,129,0.45); background: rgba(16,185,129,0.04); }
.cma-avatar, .cma-avatar-img { width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0; }
.cma-avatar { display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.82rem; color: #fff; background: linear-gradient(135deg, #34d399, #059669); }
.cma-avatar-img { object-fit: cover; }
.cma-text { display: flex; flex-direction: column; gap: 0; min-width: 0; }
.cma-name { font-size: 0.85rem; font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cma-filiere { font-size: 0.72rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

/* Événements */
.club-events-list { display: flex; flex-direction: column; gap: 0.6rem; }
.club-event-row { display: flex; align-items: center; gap: 12px; padding: 0.6rem 0.75rem; border: 1px solid var(--border-color); border-radius: 12px; background: rgba(255,255,255,0.55); }
.cev-date { flex-shrink: 0; width: 48px; height: 48px; border-radius: 10px; background: rgba(245,158,11,0.1); color: #d97706; display: flex; flex-direction: column; align-items: center; justify-content: center; }
.cev-day { font-size: 1.1rem; font-weight: 900; line-height: 1; }
.cev-mon { font-size: 0.62rem; font-weight: 700; text-transform: uppercase; }
.cev-info { display: flex; flex-direction: column; gap: 1px; min-width: 0; }
.cev-title { font-size: 0.9rem; font-weight: 700; color: var(--text-primary); }
.cev-meta { font-size: 0.76rem; color: var(--text-muted); }
</style>
@endsection
