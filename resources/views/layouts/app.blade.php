<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EduPlatform') - Projet Universitaire</title>
    
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <!-- Link to custom premium CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ filemtime(public_path('css/style.css')) }}">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body>

    <!-- Header & Navbar -->
    <header class="main-header glass">
        <nav class="container navbar">
            {{-- Zone gauche : logo --}}
            <div class="navbar-left">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="EduBlog Logo" class="nav-logo">
                </a>
            </div>

            {{-- Zone centre : menu --}}
            <div class="navbar-center">
            <nav class="nav-links">
                {{-- Liens principaux --}}
                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('parcours.index') }}" class="nav-link {{ Request::is('parcours*') || Request::is('majors*') ? 'active' : '' }}">Parcours</a>
                <a href="{{ route('clubs.index') }}" class="nav-link {{ Request::is('clubs') || Request::is('clubs/*') ? 'active' : '' }}">Clubs</a>
                <a href="{{ route('events.index') }}" class="nav-link {{ Request::is('events*') ? 'active' : '' }}">Événements</a>
                <a href="{{ route('posts.index') }}" class="nav-link {{ Request::is('posts') || (Request::is('posts/*') && !Request::is('posts/create')) ? 'active' : '' }}">Ressources</a>
                {{-- Écosystème étudiant regroupé dans un menu déroulant --}}
                <div class="nav-dropdown">
                    <button type="button" class="nav-link nav-dropdown-trigger {{ Request::is('ecosystem/*') ? 'active' : '' }}">
                        Espace Étudiant
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </button>
                    <div class="dropdown-menu glass">
                        <a href="/ecosystem/ai-space" class="dropdown-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="10" rx="2"/><circle cx="12" cy="5" r="2"/><path d="M12 7v4"/><line x1="8" y1="16" x2="8" y2="16"/><line x1="16" y1="16" x2="16" y2="16"/></svg>
                            Assistant IA
                        </a>
                        <a href="/ecosystem/find-teammates" class="dropdown-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Find Teammates
                        </a>
                        <a href="/ecosystem/lost-found" class="dropdown-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Lost &amp; Found
                        </a>
                        <a href="/ecosystem/career-center" class="dropdown-item">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                            Career Center
                        </a>
                    </div>
                </div>
                @auth
                    @if(Auth::user()->isVerifiedRecruiter() || Auth::user()->is_admin)
                    <a href="{{ route('talents.index') }}" class="nav-link {{ Request::is('talents*') ? 'active' : '' }}">Talents</a>
                    @endif
                @endauth
            </nav>
            </div>

            {{-- Zone droite : actions + profil --}}
            <div class="navbar-right">
                {{-- Actions rapides (icônes regroupées) --}}
                <div class="nav-actions">
                    {{-- Recherche --}}
                    <a href="{{ route('search') }}" class="nav-friend-bell {{ Request::is('search*') ? 'active' : '' }}" title="Recherche">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </a>
                    @auth
                    {{-- Notifications --}}
                    @php $unreadNtf = Auth::user()->unreadNotificationsCount(); @endphp
                    <a href="{{ route('notifications.index') }}" class="nav-friend-bell {{ Request::is('notifications*') ? 'active' : '' }}" title="Notifications">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                        @if($unreadNtf > 0)<span class="nav-friend-badge">{{ $unreadNtf }}</span>@endif
                    </a>

                    {{-- Messagerie --}}
                    @php $unreadMsg = Auth::user()->unreadMessagesCount(); @endphp
                    <a href="{{ route('messages.index') }}" class="nav-friend-bell {{ Request::is('messages*') ? 'active' : '' }}" title="Messagerie">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        @if($unreadMsg > 0)<span class="nav-friend-badge">{{ $unreadMsg }}</span>@endif
                    </a>

                    {{-- Demandes d'amis --}}
                    @php $pendingCount = Auth::user()->pendingRequestsCount(); @endphp
                    <a href="{{ route('friends.requests') }}" class="nav-friend-bell {{ Request::is('friends*') ? 'active' : '' }}" title="Demandes d'amis">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        @if($pendingCount > 0)<span class="nav-friend-badge">{{ $pendingCount }}</span>@endif
                    </a>

                    {{-- Admin : vérification recruteurs --}}
                    @if(Auth::user()->is_admin)
                        @php $pendingRecruiters = \App\Models\User::where('account_type','recruiter')->where('recruiter_status','pending')->count(); @endphp
                        <a href="{{ route('admin.recruiters') }}" class="nav-friend-bell {{ Request::is('admin*') ? 'active' : '' }}" title="Recruteurs en attente">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                            @if($pendingRecruiters > 0)<span class="nav-friend-badge">{{ $pendingRecruiters }}</span>@endif
                        </a>
                    @endif
                    @endauth
                </div>

                @auth
                    <!-- Dropdown Board for User -->
                    <div class="user-dropdown">
                        <button class="dropdown-trigger user-profile">
                            <span class="nav-avatar">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="dropdown-chevron">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="dropdown-menu glass">
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                    <rect x="3" y="3" width="7" height="9"/><rect x="14" y="3" width="7" height="5"/><rect x="14" y="12" width="7" height="9"/><rect x="3" y="16" width="7" height="5"/>
                                </svg>
                                Tableau de bord
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Paramètres
                            </a>
                            <a href="{{ route('my-articles') }}" class="dropdown-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                    <path d="M12 20l9-5-9-5-9 5 9 5z"/>
                                    <polyline points="12 12 21 7 12 2 3 7 12 12"/>
                                </svg>
                                Mes publications
                            </a>
                            <a href="{{ route('portfolio.edit') }}" class="dropdown-item">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                                    <rect x="3" y="3" width="18" height="18" rx="2"/>
                                    <path d="M9 9h1v6H9zM14 9h1v6h-1z"/>
                                </svg>
                                Mon Portfolio
                            </a>
                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="POST" style="display: block; width: 100%;">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger" style="width: 100%; border: none; background: none; font-family: inherit; font-size: inherit; text-align: left; cursor: pointer; display: flex; align-items: center; gap: 8px;">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--error);">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                        <polyline points="16 17 21 12 16 7"></polyline>
                                        <line x1="21" y1="12" x2="9" y2="12"></line>
                                    </svg>
                                    Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="nav-link {{ Request::is('login') ? 'active' : '' }}">Connexion</a>
                    <a href="{{ route('register') }}" class="nav-link nav-register {{ Request::is('register') ? 'active' : '' }}">Inscription</a>
                @endguest
            </div>{{-- /.navbar-right --}}
            
        </nav>
    </header>

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="container">
            
            <!-- Flash Toasts (flottants — n'affectent pas la mise en page) -->
            <div class="flash-toasts">
            <!-- Flash Alert for Success Session -->
            @if(session('success'))
                <div class="alert alert-success glass" id="flash-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <div class="alert-content">
                        <div class="alert-title">Succès</div>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button class="alert-close" onclick="document.getElementById('flash-success').remove()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            @endif

            <!-- Flash Alert for Errors (or Global Validation Errors) -->
            @if($errors->any())
                <div class="alert alert-error glass" id="flash-error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <div class="alert-content">
                        <div class="alert-title">Erreur</div>
                        <div>Veuillez corriger les erreurs ci-dessous.</div>
                    </div>
                    <button class="alert-close" onclick="document.getElementById('flash-error').remove()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            @endif
            </div>{{-- /.flash-toasts --}}

            <style>
                .flash-toasts {
                    position: fixed;
                    top: 88px;
                    right: 20px;
                    z-index: 1200;
                    width: min(390px, calc(100vw - 40px));
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                    pointer-events: none;
                }
                .flash-toasts .alert {
                    pointer-events: auto;
                    margin: 0;
                    box-shadow: var(--shadow-lg, 0 14px 38px rgba(15,23,42,.20));
                    animation: flashIn .35s cubic-bezier(.16,1,.3,1);
                }
                .flash-toasts .alert.flash-out { animation: flashOut .3s ease forwards; }
                @keyframes flashIn  { from { opacity: 0; transform: translateX(26px) scale(.97); } to { opacity: 1; transform: none; } }
                @keyframes flashOut { to { opacity: 0; transform: translateX(26px) scale(.97); } }
                @media (max-width: 600px) {
                    .flash-toasts { top: 74px; right: 12px; left: 12px; width: auto; }
                }
            </style>
            <script>
                document.querySelectorAll('.flash-toasts .alert').forEach(function (el) {
                    setTimeout(function () {
                        el.classList.add('flash-out');
                        setTimeout(function () { el.remove(); }, 300);
                    }, 4500); // disparaît tout seul après 4,5s
                });
            </script>

            <!-- Email verification banner (soft reminder, non-blocking) -->
            @auth
                @if(!auth()->user()->hasVerifiedEmail() && !request()->routeIs('verification.*'))
                <div class="verify-banner">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <span>Votre adresse e-mail n'est pas encore vérifiée.</span>
                    <a href="{{ route('verification.notice') }}">Vérifier maintenant →</a>
                </div>
                <style>
                .verify-banner { display:flex; align-items:center; justify-content:center; gap:9px; flex-wrap:wrap; padding:.65rem 1rem; margin:0 auto 1.25rem; max-width:1100px; background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.3); border-radius:12px; color:#b45309; font-size:.83rem; font-weight:600; }
                .verify-banner a { color:#d97706; font-weight:800; text-decoration:none; }
                .verify-banner a:hover { text-decoration:underline; }
                </style>
                @endif
            @endauth

            <!-- Page-Specific Contents -->
            @yield('content')
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-inner">

            <!-- Top grid: 4 columns -->
            <div class="footer-grid">

                <!-- Col 1 — Brand -->
                <div class="footer-col footer-brand">
                    <div class="footer-logo">
                        b<span class="footer-logo-dot">●</span>g
                    </div>
                    <p class="footer-brand-desc">
                        Une plateforme d'échange construite par et pour les futurs ingénieurs de l'École Nationale des Sciences Appliquées de Kénitra (ENSAK).
                    </p>
                </div>

                <!-- Col 2 — Navigation -->
                <div class="footer-col">
                    <h4 class="footer-col-title">Navigation</h4>
                    <ul class="footer-col-links">
                        <li><a href="{{ url('/') }}">Accueil / Présentation</a></li>
                        <li><a href="{{ route('majors.index') }}">Nos Filières de Formation</a></li>
                        <li><a href="{{ route('clubs.index') }}">Vie associative &amp; Clubs</a></li>
                        <li><a href="{{ route('posts.index') }}">Ressources en ligne</a></li>
                    </ul>
                </div>

                <!-- Col 3 — Admissions & Contact -->
                <div class="footer-col">
                    <h4 class="footer-col-title">Admissions &amp; Contact</h4>
                    <ul class="footer-col-links">
                        <li>
                            <a href="https://ensa.uit.ac.ma/admission" target="_blank" rel="noopener">
                                Concours &amp; Seuils
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:4px;opacity:.7"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+212537374747">
                                Contacter le secrétariat
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-left:4px;opacity:.7"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13 19.79 19.79 0 0 1 1.61 4.38 2 2 0 0 1 3.58 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.06 6.06l1.97-1.97a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </a>
                        </li>
                        <li>
                            <a href="https://uit.ac.ma" target="_blank" rel="noopener">
                                Université Ibn Tofail
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-left:4px;opacity:.7"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Col 4 — À propos -->
                <div class="footer-col">
                    <h4 class="footer-col-title">À Propos d'EduBlog</h4>
                    <p class="footer-about-text">
                        Ce site simule le futur portail d'orientation intégré d'EduBlog pour les élèves ingénieurs d'ENSA Kénitra, améliorant la visibilité des différentes filières.
                    </p>
                </div>

            </div><!-- /footer-grid -->

            <!-- Bottom bar -->
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} EduBlog ENSA Kénitra. Tous droits réservés.</span>
                <span>Conçu en synergie avec les étudiants de l'Université Ibn Tofail.</span>
            </div>

        </div>
    </footer>

    <style>
    /* ── FOOTER ───────────────────────────────────────────────── */
    .main-footer {
        background: #0f172a;
        color: rgba(255,255,255,0.75);
        margin-top: 4rem;
        border-top: 1px solid rgba(255,255,255,0.07);
    }
    .footer-inner {
        max-width: 1200px;
        margin: 0 auto;
        padding: 3.5rem 1.5rem 0;
    }
    .footer-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr 1fr 1.2fr;
        gap: 2.5rem;
        padding-bottom: 3rem;
        border-bottom: 1px solid rgba(255,255,255,0.08);
    }
    @media (max-width: 900px) {
        .footer-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 540px) {
        .footer-grid { grid-template-columns: 1fr; }
    }

    /* Brand column */
    .footer-logo {
        font-size: 1.7rem;
        font-weight: 900;
        font-family: var(--font-heading);
        color: white;
        letter-spacing: -0.04em;
        margin-bottom: 1rem;
    }
    .footer-logo-dot {
        color: #6EE7B7;
        font-size: 1.4rem;
    }
    .footer-brand-desc {
        font-size: 0.875rem;
        line-height: 1.65;
        color: rgba(255,255,255,0.55);
    }

    /* Column headings */
    .footer-col-title {
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.45);
        margin-bottom: 1.1rem;
    }

    /* Links list */
    .footer-col-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0.7rem;
    }
    .footer-col-links a {
        font-size: 0.88rem;
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: color 0.18s;
    }
    .footer-col-links a:hover { color: #6EE7B7; }

    /* About text */
    .footer-about-text {
        font-size: 0.875rem;
        line-height: 1.65;
        color: rgba(255,255,255,0.55);
        margin-bottom: 1.1rem;
    }

    /* Version badge */
    .footer-version-badge {
        display: inline-block;
        padding: 5px 14px;
        border: 1px solid rgba(110,231,183,0.35);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: #6EE7B7;
        background: rgba(110,231,183,0.07);
    }

    /* Bottom bar */
    .footer-bottom {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 1.25rem 0 1.5rem;
        font-size: 0.8rem;
        color: rgba(255,255,255,0.35);
    }
    </style>

    <!-- Cookie Consent Banner -->
<x-cookie-banner />

<script>
    (function() {
        const banner = document.getElementById('cookie-consent');
        if (!banner) return;
        // Helper to read cookie value
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
        const existing = getCookie('cookie_consent');
        if (existing) {
            banner.style.display = 'none';
            return;
        }
        // Attach click handlers
        const acceptBtn = banner.querySelector('.cookie-btn--accept');
        const rejectBtn = banner.querySelector('.cookie-btn--reject');
        function setConsent(value) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (365*24*60*60*1000));
            document.cookie = `cookie_consent=${value}; expires=${expires.toUTCString()}; path=/; SameSite=Lax`;
            banner.style.display = 'none';
        }
        acceptBtn && acceptBtn.addEventListener('click', () => setConsent('accepted'));
        rejectBtn && rejectBtn.addEventListener('click', () => setConsent('rejected'));
    })();
</script>

</body>
</html>
