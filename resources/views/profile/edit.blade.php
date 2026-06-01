@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')

    <div class="auth-container form-container glass">
        
        <div class="form-title-group">
            <h1>Mon <span class="gradient-title">Profil</span></h1>
            <p>Visualisez et modifiez vos informations personnelles d\'auteur.</p>
        </div>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Champ : Nom Complet -->
            <div class="form-group">
                <label for="name" class="form-label">Nom complet</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" placeholder="Votre nom complet..." required autofocus>
                @error('name')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Email -->
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Votre adresse email..." required>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 30px 0;">

            <div class="form-title-group" style="text-align: left; margin-bottom: 20px;">
                <h3 style="font-size: 18px; color: var(--text-primary);">Changer le mot de passe</h3>
                <p style="font-size: 13px; color: var(--text-muted); margin-top: 4px;">Laissez ces champs vides si vous ne souhaitez pas modifier votre mot de passe.</p>
            </div>

            <!-- Champ : Nouveau Mot de passe -->
            <div class="form-group">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Minimum 8 caractères...">
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Confirmation du Mot de passe -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmez le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ressaisissez le nouveau mot de passe...">
            </div>

            <!-- Bouton d'action -->
            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>

    </div>

@endsection
