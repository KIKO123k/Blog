@extends('layouts.app')

@section('title', 'Connexion Auteur')

@section('content')

    <div class="auth-container form-container glass">
        
        <div class="form-title-group">
            <h1>Espace <span class="gradient-title">Auteur</span></h1>
            <p>Connectez-vous à votre compte pour gérer et publier vos articles.</p>
        </div>

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <!-- Champ : Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Ex. jean.dupont@univ.fr..." required autofocus>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Entrez votre mot de passe..." required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Case à cocher : Se souvenir de moi -->
            <div class="form-checkbox-group">
                <input type="checkbox" name="remember" id="remember" class="form-checkbox">
                <label for="remember" class="form-label" style="margin-bottom: 0; cursor: pointer; user-select: none;">Se souvenir de moi</label>
            </div>

            <!-- Bouton d'action -->
            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Se connecter
                </button>
            </div>
            
            <div class="auth-footer-text">
                <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
            </div>

            <div class="auth-footer-text">
                Pas encore de compte ? <a href="{{ route('register') }}">Inscrivez-vous ici</a>
            </div>
        </form>

    </div>

@endsection
