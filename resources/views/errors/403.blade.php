@extends('layouts.app')
@section('title', 'Accès refusé — 403')

@section('content')
<div class="err-page">
    <div class="err-icon-wrap">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#dc2626" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    </div>
    <div class="err-code" style="font-size: clamp(3.5rem, 10vw, 5.5rem);">403</div>
    <h1 class="err-title">Accès refusé</h1>
    <p class="err-text">
        {{ $exception->getMessage() ?: "Vous n'avez pas l'autorisation d'accéder à cette ressource. Si c'est un CV, seuls les recruteurs vérifiés et le propriétaire peuvent le consulter." }}
    </p>
    <div class="err-actions">
        <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 11px 24px;">Retour à l'accueil</a>
    </div>
</div>

<style>
.err-page { max-width: 560px; margin: 70px auto; padding: 0 1.5rem; text-align: center; }
.err-icon-wrap { width: 84px; height: 84px; border-radius: 50%; background: rgba(239,68,68,.1); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
.err-code { font-weight: 900; letter-spacing: -.05em; line-height: 1; color: var(--text-primary); margin-bottom: 1rem; }
.err-title { font-size: 1.4rem; font-weight: 800; color: var(--text-primary); margin-bottom: .6rem; }
.err-text { font-size: .92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 2rem; }
.err-actions { display: flex; align-items: center; justify-content: center; gap: 1.25rem; flex-wrap: wrap; }
</style>
@endsection
