@extends('layouts.app')

@section('title', 'Inscription Auteur')

@section('content')

    <div class="auth-container form-container glass">
        
        <div class="form-title-group">
            <h1>Devenir <span class="gradient-title">Auteur</span></h1>
            <p>Créez votre compte pour commencer à publier vos articles sur le blog.</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            
            <!-- Champ : Nom Complet -->
            <div class="form-group">
                <label for="name" class="form-label">Nom complet</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ex. Jean Dupont..." required autofocus>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Ex. jean.dupont@univ.fr..." required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 caractères..." required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Confirmation du Mot de passe -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmez le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ressaisissez le mot de passe..." required>
            </div>

            <!-- Bouton d'action -->
            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    S'inscrire
                </button>
            </div>
            
            <div class="auth-footer-text">
                Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous ici</a>
            </div>
        </form>

    </div>

@endsection
