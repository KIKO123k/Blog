@extends('layouts.app')
@section('title', 'Vérifiez votre adresse e-mail')

@section('content')
<div class="form-container glass" style="max-width: 520px; margin: 60px auto; padding: 40px; text-align: center;">

    <div style="width:64px;height:64px;border-radius:50%;background:rgba(110,231,183,.15);display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
    </div>

    <h1 style="font-size:1.5rem;font-weight:900;letter-spacing:-.03em;margin-bottom:.5rem;">Vérifiez votre <span class="gradient-title">e-mail</span></h1>

    <p style="color:var(--text-muted);font-size:.92rem;line-height:1.65;margin-bottom:1.5rem;">
        Un lien de vérification a été envoyé à<br>
        <strong style="color:var(--text-primary)">{{ auth()->user()->email }}</strong><br>
        Cliquez sur ce lien pour confirmer votre adresse.
    </p>

    @if(session('success'))
    <div style="padding:.8rem 1rem;background:rgba(16,185,129,.1);color:#059669;border:1px solid rgba(16,185,129,.2);border-radius:12px;font-size:.85rem;font-weight:600;margin-bottom:1.25rem;">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary" style="width:100%;padding:12px;">
            Renvoyer le lien de vérification
        </button>
    </form>

    <p style="font-size:.78rem;color:var(--text-muted);margin-top:1.25rem;">
        Vous n'avez rien reçu ? Vérifiez vos spams, ou renvoyez le lien.
    </p>
</div>
@endsection
