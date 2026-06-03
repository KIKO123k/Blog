@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <!-- Hero Banner -->
    <section class="landing-hero">
        <h1 class="landing-hero-title">Partagez votre Savoir sur <span class="gradient-title">EduBlog</span></h1>
        <p class="landing-hero-subtitle">Une plateforme d'échange et de publication moderne conçue pour les étudiants et passionnés du développement web.</p>
        
        <div class="landing-hero-actions">
            <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg">Découvrir les Articles</a>
            @guest
                <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Créer un Compte</a>
            @endguest
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-secondary btn-lg">Rédiger un Article</a>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <h2 class="section-title text-center" style="margin-bottom: 40px;">Pourquoi utiliser EduBlog ?</h2>
        <div class="features-grid">
            <div class="feature-card glass">
                <div class="feature-icon">📝</div>
                <h3>Rédaction intuitive</h3>
                <p>Un éditeur simple et épuré pour rédiger et publier vos articles en quelques clics.</p>
            </div>
            <div class="feature-card glass">
                <div class="feature-icon">💬</div>
                <h3>Échanges constructifs</h3>
                <p>Discutez avec vos lecteurs, répondez aux questions et partagez vos retours d'expérience.</p>
            </div>
            <div class="feature-card glass">
                <div class="feature-icon">⚡</div>
                <h3>Expérience premium</h3>
                <p>Profitez d'une interface web ultra-rapide, moderne, fluide et entièrement responsive.</p>
            </div>
        </div>
    </section>

    <!-- Recent Posts Section -->
    <section class="recent-posts-section" style="margin-top: 60px;">
        <div class="posts-header">
            <div>
                <h2 class="section-title">Publications Récentes</h2>
            </div>
            <a href="{{ route('posts.index') }}" class="read-more-link" style="font-size: 16px;">
                Voir tous les articles
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                    <polyline points="12 5 19 12 12 19"></polyline>
                </svg>
            </a>
        </div>

        <div class="posts-grid">
            @forelse($recentPosts as $post)
                <article class="post-card glass">
                    <div class="post-card-image">
                        @if($post->image)
                            <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        @else
                            <div class="image-fallback">
                                {{ substr($post->title, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    <div class="post-card-content">
                        <div class="post-card-meta">
                            <span class="post-card-author">
                                <span class="author-avatar">{{ strtoupper(substr($post->user?->name ?? 'Auteur anonyme', 0, 1)) }}</span>
                                {{ $post->user?->name ?? 'Auteur anonyme' }}
                            </span>
                            <span>{{ $post->created_at->format('d/m/Y') }}</span>
                        </div>
                        
                        <h3 class="post-card-title">{{ $post->title }}</h3>
                        
                        <p class="post-card-excerpt">
                            {{ Str::limit($post->content, 120, '...') }}
                        </p>
                        
                        <div class="post-card-footer">
                            <a href="{{ route('posts.show', $post->id) }}" class="read-more-link">
                                Lire l'article
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state glass" style="grid-column: 1 / -1;">
                    <div class="empty-state-icon">📝</div>
                    <h3>Aucun article publié</h3>
                    <p>Il n'y a pas encore d'article sur ce blog.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section" style="margin-top: 80px;">
        <div class="stats-grid">
            <div class="stat-card glass">
                <span class="stat-value">{{ $postsCount }}</span>
                <span class="stat-label">Articles Rédigés</span>
            </div>
            <div class="stat-card glass">
                <span class="stat-value">{{ $commentsCount }}</span>
                <span class="stat-label">Commentaires</span>
            </div>
            <div class="stat-card glass">
                <span class="stat-value">{{ $authorsCount }}</span>
                <span class="stat-label">Auteurs Actifs</span>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section class="landing-cta glass">
        <h2>Prêt à partager votre savoir ?</h2>
        <p>Rejoignez notre communauté en créant votre profil d'auteur et rédigez votre premier article dès aujourd'hui.</p>
        <div style="margin-top: 24px;">
            @guest
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Commencer maintenant</a>
            @endguest
            @auth
                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-lg">Rédiger un article</a>
            @endauth
        </div>
    </section>
@endsection
