@extends('layouts.app')

@section('title', $post->title)

@section('content')

    <!-- Bouton de retour -->
    <div class="back-link-wrapper">
        <a href="{{ route('posts.index') }}" class="back-link">
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
                <span>Rédigé par <strong>@if($post->user)<a href="{{ route('portfolio.show', $post->user) }}" style="color:inherit;text-decoration:none;border-bottom:1px solid rgba(110,231,183,.5);transition:border-color .18s" onmouseover="this.style.borderBottomColor='#6EE7B7'" onmouseout="this.style.borderBottomColor='rgba(110,231,183,.5)'">{{ $post->user->name }}</a>@else Auteur anonyme @endif</strong></span>
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
            <div class="post-detail-meta-item">
                @php $avgRating = (int) round($post->average_rating ?? 0); @endphp
                <div class="post-rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <svg class="star-icon {{ $i <= $avgRating ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor" style="width: 18px; height: 18px;">
                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                        </svg>
                    @endfor
                    <span class="rating-text">({{ $avgRating }}/5)</span>
                </div>
            </div>
        </div>
    </article>

    @auth
    {{-- Barre d'actions : reposter / partager --}}
    @php $reposted = auth()->user()->hasReposted($post->id); @endphp
    <div class="post-actions-bar">
        <form method="POST" action="{{ route('posts.repost', $post->slug ?? $post->id) }}">
            @csrf
            <button type="submit" class="pa-btn {{ $reposted ? 'pa-active' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                {{ $reposted ? 'Reposté sur votre portfolio ✓' : 'Reposter sur mon portfolio' }}
            </button>
        </form>
        <a href="{{ route('posts.share.form', $post->slug ?? $post->id) }}" class="pa-btn pa-share">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><polyline points="16 6 12 2 8 6"/><line x1="12" y1="2" x2="12" y2="15"/></svg>
            Partager à un ami
        </a>
    </div>
    <style>
        .post-actions-bar { display: flex; flex-wrap: wrap; gap: .6rem; margin: 1.5rem 0; }
        .pa-btn { display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; border-radius: 11px; font-size: .85rem; font-weight: 700; cursor: pointer; border: 1.5px solid var(--border-color); background: rgba(255,255,255,.7); color: var(--text-primary); text-decoration: none; transition: border-color .18s, background .18s, transform .15s; font-family: inherit; }
        .pa-btn:hover { transform: translateY(-2px); border-color: rgba(110,231,183,.6); }
        .pa-btn.pa-active { background: rgba(16,185,129,.12); color: #059669; border-color: rgba(16,185,129,.3); }
        .pa-share { background: rgba(14,165,233,.1); color: #0284c7; border-color: rgba(14,165,233,.25); }
    </style>
    @endauth

    <!-- Image grand format si existante -->
    @if($post->image)
        <div class="post-detail-hero-image">
            <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" alt="{{ $post->title }}">
        </div>
    @endif

    <!-- Contenu de l'article -->
    <section class="post-detail-content">
        {!! nl2br(e($post->content)) !!}
    </section>

    <!-- Rating Form for Readers -->
    @if(auth()->check() && auth()->id() !== $post->user_id)
        <section class="star-rating-section">
            <div class="star-rating-card">
                <div class="star-rating-header">
                    <div class="star-rating-icon">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="star-rating-title">Votre avis compte</h3>
                        <p class="star-rating-sub">Notez cet article pour aider la communauté</p>
                    </div>
                </div>

                <form action="{{ route('ratings.store', $post) }}" method="POST" id="rating-form">
                    @csrf
                    <input type="hidden" name="rating" id="rating-value" value="0">

                    <div class="star-picker">
                        @for($i = 5; $i >= 1; $i--)
                        <button type="button" class="star-btn" data-value="{{ $i }}" aria-label="{{ $i }} étoiles">
                            <svg viewBox="0 0 24 24" fill="currentColor">
                                <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                            </svg>
                        </button>
                        @endfor
                    </div>

                    <div class="star-rating-footer">
                        <span class="star-label-text" id="star-label">Sélectionnez une note</span>
                        <button type="submit" class="star-submit-btn" id="star-submit" disabled>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Envoyer ma note
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <style>
        .star-rating-section {
            margin-top: 2.5rem;
        }
        .star-rating-card {
            background: rgba(255,255,255,0.85);
            border: 1px solid var(--border-color, #e2e8f0);
            border-radius: 20px;
            padding: 1.75rem 2rem;
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }
        .star-rating-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .star-rating-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #6EE7B7, #34d399);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            flex-shrink: 0;
        }
        .star-rating-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-primary, #0f172a);
            margin: 0 0 2px;
        }
        .star-rating-sub {
            font-size: 0.82rem;
            color: var(--text-muted, #64748b);
            margin: 0;
        }

        /* Star picker — RTL trick: stars go right to left */
        .star-picker {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 6px;
            margin-bottom: 1.25rem;
        }
        .star-btn {
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
            transition: transform 0.15s;
        }
        .star-btn svg {
            width: 38px;
            height: 38px;
            color: #d1d5db;
            transition: color 0.15s, transform 0.15s;
            filter: drop-shadow(0 1px 2px rgba(0,0,0,0.08));
        }
        /* Hover: colour this star and all stars to the right */
        .star-btn:hover svg,
        .star-btn:hover ~ .star-btn svg {
            color: #f59e0b;
            transform: scale(1.15);
        }
        /* Selected state via JS class */
        .star-btn.selected svg,
        .star-btn.selected ~ .star-btn svg {
            color: #f59e0b;
        }
        .star-btn.selected svg {
            transform: scale(1.12);
        }

        .star-rating-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 0.75rem;
        }
        .star-label-text {
            font-size: 0.9rem;
            color: var(--text-muted, #64748b);
            font-style: italic;
        }
        .star-submit-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 24px;
            background: linear-gradient(135deg, #6EE7B7, #34d399);
            color: #0f172a;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.88rem;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.2s;
            font-family: inherit;
        }
        .star-submit-btn:disabled {
            opacity: 0.45;
            cursor: not-allowed;
            transform: none;
        }
        .star-submit-btn:not(:disabled):hover {
            opacity: 0.88;
            transform: translateY(-1px);
        }
        </style>

        <script>
        (function() {
            const labels = ['', 'Mauvais', 'Passable', 'Bien', 'Très bien', 'Excellent !'];
            const stars   = document.querySelectorAll('.star-btn');
            const input   = document.getElementById('rating-value');
            const label   = document.getElementById('star-label');
            const submit  = document.getElementById('star-submit');

            stars.forEach(btn => {
                btn.addEventListener('click', function() {
                    const val = parseInt(this.dataset.value);
                    input.value = val;
                    label.textContent = val + ' étoile' + (val > 1 ? 's' : '') + ' — ' + labels[val];
                    submit.disabled = false;
                    stars.forEach(s => s.classList.remove('selected'));
                    this.classList.add('selected');
                });
            });
        })();
        </script>
    @endif

    <!-- Actions d'administration (Modifier et Supprimer) - Réservé à l'auteur de l'article -->
    @if(auth()->check() && auth()->id() === $post->user_id)
        <div class="post-detail-actions">
            <a href="{{ route('posts.edit', $post) }}" class="btn btn-secondary">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg>
                Modifier l'article
            </a>
            
            <!-- Formulaire de suppression avec protection CSRF et confirmation JS -->
            <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article définitivement ? Cette action est irréversible.')">
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
            <form action="{{ route('comments.store', $post) }}" method="POST">
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
