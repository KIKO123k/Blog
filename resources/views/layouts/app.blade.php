<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Laravel Blog') - Projet Universitaire</title>
    
    <!-- Link to custom premium CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Header & Navbar -->
    <header class="main-header glass">
        <div class="container navbar">
            <a href="{{ url('/') }}" class="logo">
                <span class="logo-icon"></span>
                <span>EduBlog</span>
            </a>
            
            <nav class="nav-links">
                <a href="{{ url('/') }}" class="nav-link {{ Request::is('/') || Request::is('posts') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('posts.create') }}" class="nav-link {{ Request::is('posts/create') ? 'active' : '' }}">Nouvel Article</a>
            </nav>
            
            <!-- Global Title Search Form -->
            <form action="{{ url('/') }}" method="GET" class="search-form">
                <button type="submit" class="search-icon-btn">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
                <input type="text" name="search" placeholder="Rechercher par titre..." class="search-input" value="{{ request('search') }}">
            </form>
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
            <p>&copy; {{ date('Y') }} EduBlog. Développé dans le cadre d'un projet universitaire en architecture MVC Laravel 12.</p>
        </div>
    </footer>

</body>
</html>
