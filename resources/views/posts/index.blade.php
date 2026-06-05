@extends('layouts.app')

@section('title', 'Articles')

@section('content')

    <!-- Hero / Section d'introduction -->
    <section class="hero">
        <h1>Tous nos <span class="gradient-title">Articles</span></h1>
        
        <!-- Search bar inside Hero -->
        <div class="hero-search">
            <form action="{{ route('posts.index') }}" method="GET" class="search-form">
                <span class="search-icon-left">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="text" name="search" placeholder="Rechercher par titre..." class="search-input" value="{{ request('search') }}">
                <button type="submit" class="btn-search">Rechercher</button>
            </form>
        </div>
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
                            <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
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
                            <div class="post-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="star-icon {{ $i <= ($post->rating ?? 0) ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                @endfor
                                <span class="rating-text">({{ $post->rating ?? 0 }}/5)</span>
                            </div>

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
                        <li class="disabled"><span>Précédent</span></li>
                    @else
                        <li><a href="{{ $posts->previousPageUrl() }}" rel="prev">Précédent</a></li>
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
                        <li><a href="{{ $posts->nextPageUrl() }}" rel="next">Suivant</a></li>
                    @else
                        <li class="disabled"><span>Suivant</span></li>
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
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Voir tous les articles</a>
            @else
                <h3>Aucun article publié</h3>
                <p>Il n'y a pas encore d'article sur ce blog. Soyez le premier à en rédiger un !</p>
                <a href="{{ route('posts.create') }}" class="btn btn-primary">Publier un article</a>
            @endif
        </div>
    @endif

@endsection
