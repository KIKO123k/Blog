<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'EduPlatform') - Projet Universitaire</title>
    
    <link rel="icon" href="{{ asset('images/logo1.png') }}" type="image/png">
    <!-- Link to custom premium CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Header & Navbar -->
    <header class="main-header glass">
        <div class="container navbar">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('images/logo.png') }}" alt="EduBlog Logo" class="nav-logo">
            </a>
            
            <nav class="nav-links">
                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('majors.index') }}" class="nav-link {{ Request::is('majors') || Request::is('majors/*') ? 'active' : '' }}">Filières</a>
                <a href="{{ route('clubs.index') }}" class="nav-link {{ Request::is('clubs') || Request::is('clubs/*') ? 'active' : '' }}">Clubs</a>
                <a href="{{ route('posts.index') }}" class="nav-link {{ Request::is('posts') || (Request::is('posts/*') && !Request::is('posts/create')) ? 'active' : '' }}">Ressources</a>
                @auth
                    <!-- Dropdown Board for User -->
                    <div class="user-dropdown">
                        <button class="dropdown-trigger">
                            <span class="author-avatar" style="width: 24px; height: 24px; font-size: 10px;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            {{ Auth::user()->name }}
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="dropdown-chevron">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </button>
                        <div class="dropdown-menu glass">
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
                    <a href="{{ route('register') }}" class="nav-link {{ Request::is('register') ? 'active' : '' }}">Inscription</a>
                @endguest
            </nav>
            
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="main-content">
        <div class="container">
            
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

            <!-- Page-Specific Contents -->
            @yield('content')
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">

            <!-- Footer Top: Last Edit + License Notice -->
            <div class="footer-notice">
                <p>
                    Le contenu de ce site est disponible sous la licence
                    <a href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank" rel="noopener">Creative Commons Attribution-ShareAlike 4.0</a>.
                    En utilisant ce site, vous acceptez les
                    <a href="#">Conditions d'utilisation</a> et la
                    <a href="#">Politique de confidentialité</a>.
                    <strong>EduBlog®</strong> est un projet académique à but non lucratif.
                </p>
            </div>

            <!-- Footer Links -->
<nav class="footer-links">
    @foreach($footerLinks as $link)
        <a href="{{ $link->url }}">{{ $link->title }}</a>
    @endforeach
</nav>

            <!-- Footer Bottom: Copyright -->
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} EduPlatform.</span>
                <span>Développé avec Laravel 12 &amp; PHP.</span>
                <span>Tous droits réservés.</span>
            </div>

        </div>
    </footer>

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
