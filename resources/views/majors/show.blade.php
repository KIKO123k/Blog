@extends('layouts.app')

@section('title', $data['title'])

@section('content')
    <section class="major-detail-section" style="margin-top: 60px;">
        <div class="post-card glass" style="max-width: 800px; margin: 0 auto;">
            <div class="post-card-image" style="height: auto;">
                <img src="{{ asset($data['image']) }}" alt="{{ $data['title'] }}" style="width: 100%; height: auto; object-fit: cover;">
            </div>
            <div class="post-card-content">
                <h2 class="post-card-title" style="margin-top: 24px;">{{ $data['title'] }}</h2>
                <p class="post-card-excerpt" style="margin-top: 16px;">{{ $data['description'] }}</p>
                <div class="post-card-footer" style="margin-top: 24px;">
                    <a href="{{ route('home') }}" class="read-more-link">← Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </section>
@endsection
