@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')

    <div class="auth-container form-container glass">

        <div class="form-title-group">
            <h1>Mot de passe <span class="gradient-title">Oublié</span></h1>
            <p>Entrez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success glass" style="margin-bottom: 20px;">
                <div class="alert-content">
                    <div class="alert-title">Email envoyé</div>
                    <div>{{ session('status') }}</div>
                </div>
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Ex. jean.dupont@univ.fr..." required autofocus>
                @error('email')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-top: 30px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px; vertical-align: middle;">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    Envoyer le lien de réinitialisation
                </button>
            </div>

            <div class="auth-footer-text">
                Vous vous souvenez ? <a href="{{ route('login') }}">Connectez-vous ici</a>
            </div>
        </form>

    </div>

@endsection
