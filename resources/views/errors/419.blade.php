@extends('layouts.app')
@section('title', 'Session expirée — 419')

@section('content')
<div class="err-page">
    <div class="err-icon-wrap" style="background: rgba(245,158,11,.1);">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div class="err-code" style="font-size: clamp(3.5rem, 10vw, 5.5rem);">419</div>
    <h1 class="err-title">Votre session a expiré</h1>
    <p class="err-text">La page est restée ouverte trop longtemps. Revenez en arrière, actualisez la page, puis réessayez.</p>
    <div class="err-actions">
        <a href="javascript:history.back()" class="btn btn-primary" style="padding: 11px 24px;">← Revenir en arrière</a>
        <a href="{{ route('home') }}" class="err-link">Accueil →</a>
    </div>
</div>

<style>
.err-page { max-width: 560px; margin: 70px auto; padding: 0 1.5rem; text-align: center; }
.err-icon-wrap { width: 84px; height: 84px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; }
.err-code { font-weight: 900; letter-spacing: -.05em; line-height: 1; color: var(--text-primary); margin-bottom: 1rem; }
.err-title { font-size: 1.4rem; font-weight: 800; color: var(--text-primary); margin-bottom: .6rem; }
.err-text { font-size: .92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 2rem; }
.err-actions { display: flex; align-items: center; justify-content: center; gap: 1.25rem; flex-wrap: wrap; }
.err-link { font-size: .88rem; font-weight: 700; color: var(--success, #059669); text-decoration: none; }
</style>
@endsection
