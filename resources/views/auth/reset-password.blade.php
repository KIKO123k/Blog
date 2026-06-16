@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')

    <div class="auth-container form-container glass">

        <div class="form-title-group">
            <h1>Nouveau <span class="gradient-title">Mot de passe</span></h1>
            <p>Choisissez un nouveau mot de passe sécurisé pour votre compte auteur.</p>
        </div>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $email) }}" required autofocus>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                    Réinitialiser le mot de passe
                </button>
            </div>

            <div class="auth-footer-text">
                <a href="{{ route('login') }}">Retour à la connexion</a>
            </div>
        </form>

    </div>

@endsection
