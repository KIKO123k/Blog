@extends('layouts.app')
@section('title', 'Page introuvable — 404')

@section('content')
<div class="err-page">
    <div class="err-code">4<span class="err-zero">0</span>4</div>
    <h1 class="err-title">Oups, cette page n'existe pas</h1>
    <p class="err-text">La page que vous cherchez a peut-être été déplacée, supprimée, ou n'a jamais existé.</p>
    <div class="err-actions">
        <a href="{{ route('home') }}" class="btn btn-primary" style="padding: 11px 24px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:5px"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            Retour à l'accueil
        </a>
        <a href="{{ route('posts.index') }}" class="err-link">Voir les ressources →</a>
    </div>
</div>

<style>
.err-page { max-width: 560px; margin: 80px auto; padding: 0 1.5rem; text-align: center; }
.err-code { font-size: clamp(5rem, 16vw, 8.5rem); font-weight: 900; letter-spacing: -.05em; line-height: 1; color: var(--text-primary); margin-bottom: 1rem; }
.err-zero { background: linear-gradient(135deg, #6EE7B7, #34d399); -webkit-background-clip: text; background-clip: text; color: transparent; }
.err-title { font-size: 1.4rem; font-weight: 800; color: var(--text-primary); margin-bottom: .6rem; }
.err-text { font-size: .92rem; color: var(--text-muted); line-height: 1.65; margin-bottom: 2rem; }
.err-actions { display: flex; align-items: center; justify-content: center; gap: 1.25rem; flex-wrap: wrap; }
.err-link { font-size: .88rem; font-weight: 700; color: var(--success, #059669); text-decoration: none; }
.err-link:hover { text-decoration: underline; }
</style>
@endsection
