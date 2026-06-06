@extends('layouts.app')

@section('title', 'Clubs Étudiants')

@section('content')
<style>
    .clubs-header {
        margin-bottom: 40px;
        text-align: center;
        padding-top: 40px;
    }

    .clubs-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        padding-bottom: 60px;
    }

    .club-card {
        position: relative;
        height: 240px;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        cursor: pointer;
        text-decoration: none;
        display: block;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .club-card:hover {
        transform: translateY(-10px) scale(1.03);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
    }

    .club-image {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        z-index: 1;
        background-color: #22c55e; /* Couleur de secours pendant le chargement */
        transition: transform 0.5s ease;
    }

    .club-card:hover .club-image {
        transform: scale(1.1);
    }

    .club-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.8) 0%, rgba(0, 0, 0, 0.2) 60%, transparent 100%);
        z-index: 2;
    }

    .club-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 24px;
        z-index: 3;
    }

    .club-name {
        color: white;
        font-size: 1.25rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
    }

    .club-description {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        margin-top: 8px;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.3s ease;
        max-height: 0;
        overflow: hidden;
    }

    .club-card:hover .club-description {
        opacity: 1;
        transform: translateY(0);
        max-height: 100px;
    }
</style>

<div class="clubs-header">
    <h1 class="section-title">Découvrez nos <span class="text-green">Clubs Étudiants</span></h1>
    <p class="hero-description" style="max-width: 700px; margin: 20px auto;">
        L'excellence académique s'accompagne d'un engagement associatif fort. Rejoignez l'un de nos 13 clubs thématiques.
    </p>
</div>

<div class="clubs-grid">
    @foreach($clubs as $club)
    <a href="#" class="club-card glass">
        <img src="{{ asset('images/clubs/' . $club['image']) }}" alt="{{ $club['name'] }}" class="club-image">
        <div class="club-overlay"></div>
        <div class="club-info">
            <h3 class="club-name">{{ $club['name'] }}</h3>
            <p class="club-description">{{ $club['description'] }}</p>
        </div>
    </a>
    @endforeach
</div>
@endsection