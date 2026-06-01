@extends('layouts.app')

@section('title', 'Accueil')

@section('content')

    <!-- Hero / Section d'introduction -->
    <section class="hero">
        <h1>Découvrez nos <span class="gradient-title">Publications</span></h1>
        <p>Projet universitaire de Blog développé en architecture MVC avec Laravel 12 et du CSS moderne entièrement fait maison.</p>
    </section>

    <!-- Header de la section Posts (Recherche & Ajout) -->
    <div class="posts-header">
        <div>
            @if($search)
                <h2 class="section-title">Résultats de recherche pour "{{ $search }}"</h2>
            @else
                <h2 class="section-title">Articles récents</h2>
            @endif
        </div>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            Nouvel Article
        </a>
    </div>

    <!-- Grille des articles -->
    @if($posts->count() > 0)
        <div class="posts-grid">
            @foreach($posts as $post)
                <article class="post-card glass">
                    
                    <!-- Cover Image / Fallback Placeholder -->
                    <div class="post-card-image">
                        @if($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
                        @else
                            <div class="image-fallback">
                                {{ substr($post->title, 0, 2) }}
                            </div>
                        @endif
                    </div>
                    
                    <!-- Card Contents -->
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
            @endforeach
        </div>

        <!-- Custom Pagination Markup -->
        @if ($posts->hasPages())
            <div class="pagination-wrapper">
                <ul class="pagination">
                    {{-- Previous Page Link --}}
                    @if ($posts->onFirstPage())
                        <li class="disabled"><span>&laquo;</span></li>
                    @else
                        <li><a href="{{ $posts->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        @if ($page == $posts->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($posts->hasMorePages())
                        <li><a href="{{ $posts->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="disabled"><span>&raquo;</span></li>
                    @endif
                </ul>
            </div>
        @endif

    @else
        <!-- Empty State -->
        <div class="empty-state glass">
            <div class="empty-state-icon">📝</div>
            @if($search)
                <h3>Aucun article trouvé</h3>
                <p>Nous n'avons trouvé aucun article correspondant à la recherche "{{ $search }}".</p>
                <a href="{{ url('/') }}" class="btn btn-secondary">Voir tous les articles</a>
            @else
                <h3>Aucun article publié</h3>
                <p>Il n'y a pas encore d'article sur ce blog. Soyez le premier à en rédiger un !</p>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Publier un article</a>
            @endif
        </div>
    @endif

@endsection
