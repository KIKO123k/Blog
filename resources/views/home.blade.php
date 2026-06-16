@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    <style>
        /* Suppression globale des espaces entre le header et le contenu */
        body, main, .main-content {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
        
        header, nav {
            margin-bottom: 0 !important;
        }

        .hero-redesign {
            position: relative;
            width: 100vw;
            left: 50%;
            right: 50%;
            margin-left: -50vw;
            margin-right: -50vw;
            
            /* Supprime les marges et occupe l'écran */
            margin-top: 0;
            padding-top: 0;
            min-height: 90vh;
            
            display: flex;
            align-items: center;
            background-color: #fff;
            overflow: hidden;
        }

        /* L'image devient le fond complet */
        .hero-student-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: 15% center; /* Optimisé pour voir le bras et le doigt */
            z-index: 1;
            pointer-events: none;
        }

        /* Overlay pour la lisibilité du texte à droite */
        .hero-overlay {
            position: absolute;
            inset: 0;
            /* Dégradé optimisé pour la transition header -> image -> texte */
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.05) 30%, rgba(255,255,255,0.85) 65%, #fff 100%);
            z-index: 2;
            pointer-events: none;
        }

        .hero-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
            display: flex;
            justify-content: flex-end; /* Pousse le texte vers l'espace vide de l'image */
            position: relative;
            z-index: 10;
        }

        .hero-content {
            max-width: 550px;
            animation: fadeInRight 1s ease-out;
            /* Ajustement pour remonter le texte et le rapprocher du doigt (vers la gauche) */
            margin-top: -100px;
            margin-right: 80px;
        }

        .section-title {
            font-size: 2.5rem;
        }

        .text-green {
            color: #289550ff;
            font-weight: 800;
        }

        .hero-title {
            font-size: 3.5rem;
            line-height: 1.1;
            font-weight: 800;
            margin-bottom: 24px;
            color: #1f2937;
        }

        .hero-description {
            font-size: 1.25rem;
            color: #4b5563;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
        }

        .btn-green {
            background-color: #22c55e;
            color: white !important;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px 0 rgba(34, 197, 94, 0.39);
        }

        .btn-green:hover {
            background-color: #16a34a;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.23);
        }

        .btn-outline {
            border: 2px solid #e5e7eb;
            padding: 14px 28px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            background-color: #f9fafb;
            border-color: #d1d5db;
        }

        /* Floating Elements */
        .floating-icon {
            position: absolute;
            opacity: 0.15;
            z-index: 1;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 992px) {
            .hero-redesign {
                min-height: 70vh;
                text-align: center;
            }
            .hero-title {
                font-size: 2.5rem;
            }
            .hero-student-bg {
                width: 100%;
                object-position: center;
                opacity: 0.3;
            }
            .hero-overlay {
                background: white;
                opacity: 0.8;
            }
            .hero-container {
                justify-content: center;
                padding: 0 20px;
            }
            .hero-actions {
                justify-content: center;
            }
            .hero-content {
                margin-top: 0;
                margin-right: 0;
            }
        }
    </style>

    <!-- Hero Banner Redesign -->
    <section class="hero-redesign">
        <!-- Background Image & Overlay -->
        <img src="{{ asset('images/hero-student.png') }}" alt="" class="hero-student-bg">
        <div class="hero-overlay"></div>

        <div class="hero-container">
            <!-- Content Area inside the empty space of the image -->
            <div class="hero-content">
                <h1 class="hero-title">
                    Partagez votre Savoir sur <span class="text-green">EduBlog</span>
                </h1>
                <p class="hero-description">
                    Découvrez des ressources éducatives, les filières d'ingénierie, les expériences académiques et les connaissances partagées par les étudiants de l'ENSA.
                </p>
                
                <div class="hero-actions">
                    <a href="{{ route('posts.index') }}" class="btn-green">
                        Découvrir les Ressources
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn-outline">
                            Créer un Compte
                        </a>
                    @endguest
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn-outline">
                            Rédiger un Article
                        </a>
                    @endauth
                </div>
            </div>
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
            @forelse($posts as $post)
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
    <!-- ENSA Majors Section -->
    <section class="majors-section" style="margin-top: 60px;">
        <div class="posts-header">
            <div>
                <h2 class="section-title">Explore ENSA Kenitra Engineering Majors</h2>
            </div>
        </div>
        <div class="posts-grid">
            @php
                $imageMap = [
                    'reseaux-et-systemes-de-telecommunications'   => 'major_telecom.png',
                    'genie-informatique'                           => 'major_informatique.png',
                    'genie-industriel'                             => 'major_industriel.png',
                    'genie-electrique'                             => 'major_electrique.png',
                    'genie-mecatronique'                           => 'major_mechatronique.png',
                    'genie-energetique-et-energies-renouvelables'  => 'major_energetique.png',
                ];
            @endphp
            @foreach($formations as $formation)
                <article class="post-card glass">
                    <div class="post-card-image">
                        @php
                            $imageName = $imageMap[$formation->slug] ?? 'logo.png';
                        @endphp
                        <img src="{{ asset('images/' . $imageName) }}" alt="{{ $formation->title }}">
                    </div>
                    <div class="post-card-content">
                        <div class="post-card-meta">
                            <span class="post-card-author">
                                <span class="author-avatar">A</span>
                                Administration ENSA Kénitra
                            </span>
                            <span>{{ now()->format('d/m/Y') }}</span>
                        </div>
                        <h3 class="post-card-title">{{ $formation->title }}</h3>
                        <p class="post-card-excerpt">{{ Str::limit($formation->description, 150) }}</p>
                        <div class="post-card-footer">
                            <a href="{{ route('majors.show', $formation->slug) }}" class="read-more-link">Découvrir la filière →</a>
                        </div>
                    </div>
                </article>
            @endforeach
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
                <span class="stat-value">{{ $usersCount }}</span>
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
