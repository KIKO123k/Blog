@extends('layouts.app')

@section('title', 'Nos Filières')

@section('content')
<section class="hero">
    <h1>Découvrez nos <span class="gradient-title">Filières d\'Excellence</span></h1>
    <p class="text-center text-muted mt-4">Formez-vous aux métiers de demain avec l\'ENSA Kénitra.</p>
</section>

<div class="posts-grid mt-12">
    @php
        $imageMap = [
            'genie-reseaux-telecommunications' => 'major_telecom.png',
            'genie-informatique' => 'major_informatique.png',
            'genie-industriel' => 'major_industriel.png',
            'genie-electrique' => 'major_electrique.png',
            'genie-mecatronique' => 'major_mechatronique.png',
            'efficacite-energetique-batiment-intelligent' => 'major_energetique.png',
        ];
    @endphp
    @foreach($majors as $major)
        <article class="post-card glass">
            <div class="post-card-image">
                @php
                    $imageName = $imageMap[$major->slug] ?? null;
                @endphp
                @if($imageName)
                    <img src="{{ asset('images/' . $imageName) }}" alt="{{ $major->title }}">
                @else
                    <div class="image-fallback">{{ substr($major->title, 0, 2) }}</div>
                @endif
            </div>
            <div class="post-card-content">
                <span class="badge" style="background-color: #e2f5ec; color: #16a34a; font-size: 11px; padding: 4px 8px; border-radius: 6px; font-weight: 600; display: inline-block; margin-bottom: 8px;">
                    {{ $major->category_label }}
                </span>
                <h3 class="post-card-title">{{ $major->title }}</h3>
                <p class="post-card-excerpt">
                    {{ Str::limit($major->description, 120) }}
                </p>
                <div class="post-card-footer">
                    <a href="{{ route('majors.show', $major->slug) }}" class="read-more-link">
                        Découvrir la filière
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </a>
                </div>
            </div>
        </article>
    @endforeach
</div>
@endsection
