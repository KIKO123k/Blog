@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <!-- Bouton de retour -->
    <div class="back-link-wrapper">
        <a href="{{ url('/') }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour aux articles
        </a>
    </div>

    <!-- En-tête de l'article -->
    <article class="post-detail-header">
        <h1 class="post-detail-title gradient-title">{{ $post->title }}</h1>
        
        <div class="post-detail-meta">
            <div class="post-detail-meta-item">
                <span class="author-avatar">{{ strtoupper(substr($post->user?->name ?? 'Auteur anonyme', 0, 1)) }}</span>
                <span>Rédigé par <strong>{{ $post->user?->name ?? 'Auteur anonyme' }}</strong></span>
            </div>
            <div class="post-detail-meta-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                <span>Publié le {{ $post->created_at->format('d F Y') }}</span>
            </div>
        </div>
    </article>

    <!-- Image grand format si existante -->
    @if($post->image)
        <div class="post-detail-hero-image">
            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
        </div>
    @endif

    <!-- Contenu de l'article -->
    <section class="post-detail-content">
        {!! nl2br(e($post->content)) !!}
    </section>

    <!-- Actions d'administration (Modifier et Supprimer) - Réservé à l'auteur de l'article -->
    @if(auth()->check() && auth()->id() === $post->user_id)
        <div class="post-detail-actions">
            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Modifier l'article
            </a>
            
            <!-- Formulaire de suppression avec protection CSRF et confirmation JS -->
            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article définitivement ? Cette action est irréversible.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                    Supprimer l'article
                </button>
            </form>
        </div>
    @endif

    <!-- Comments Section -->
    <section class="comments-section">
        <h2 class="comments-title">Commentaires ({{ $post->comments->count() }})</h2>
        
        <div class="comments-list">
            @forelse($post->comments as $comment)
                <div class="comment-card glass">
                    <div class="comment-header">
                        <span class="comment-author">
                            <span class="author-avatar">{{ strtoupper(substr($comment->author_name, 0, 1)) }}</span>
                            <strong>{{ $comment->author_name }}</strong>
                        </span>
                        <span class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="comment-body">
                        <p>{!! nl2br(e($comment->content)) !!}</p>
                    </div>
                </div>
            @empty
                <div class="empty-comments glass">
                    <p>Aucun commentaire pour le moment. Soyez le premier à réagir !</p>
                </div>
            @endforelse
        </div>

        <div class="comment-form-wrapper glass">
            <h3 class="form-subtitle">Laisser un commentaire</h3>
            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="author_name" class="form-label">Votre Nom</label>
                    <input type="text" name="author_name" id="author_name" class="form-control" value="{{ old('author_name') }}" required placeholder="Ex: Jean Dupont">
                    @error('author_name')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content" class="form-label">Votre Commentaire</label>
                    <textarea name="content" id="content" class="form-control" required placeholder="Partagez vos impressions..." style="min-height: 120px;"></textarea>
                    @error('content')
                        <span class="error-text">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Publier le commentaire
                </button>
            </form>
        </div>
    </section>
@endsection
