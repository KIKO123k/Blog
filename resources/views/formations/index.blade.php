@extends('layouts.app')

@section('title', 'Formations – ENSA Kénitra')

@section('content')
<div class="container py-5">

    {{-- Header --}}
    <div class="text-center mb-5">
        <h1 class="fw-bold">Formations ENSA Kénitra</h1>
        <p class="text-muted lead">
            L'École Nationale des Sciences Appliquées de Kénitra (ENSAK) forme des ingénieurs d'excellence
            depuis 2008. Découvrez l'ensemble des formations proposées.
        </p>
        <a href="https://ensa.uit.ac.ma" target="_blank" class="btn btn-outline-primary btn-sm">
            🌐 Site officiel ENSA
        </a>
    </div>

    {{-- Category filter --}}
    <div class="d-flex flex-wrap gap-2 justify-content-center mb-5">
        <a href="{{ route('formations.index') }}"
           class="btn btn-sm {{ !$category ? 'btn-primary' : 'btn-outline-secondary' }}">
            Toutes
        </a>
        @foreach ($categories as $key => $label)
            <a href="{{ route('formations.index', ['category' => $key]) }}"
               class="btn btn-sm {{ $category === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Formation groups --}}
    @foreach ($categories as $catKey => $catLabel)
        @if (isset($formations[$catKey]))
            <section class="mb-5">
                <h2 class="h4 fw-bold border-start border-4 border-primary ps-3 mb-4">
                    {{ $catLabel }}
                </h2>
                <div class="row g-4">
                    @foreach ($formations[$catKey] as $f)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm border-0 formation-card">
                                <div class="card-body d-flex flex-column">
                                    <span class="badge bg-primary mb-2 align-self-start">
                                        {{ $f->category_label }}
                                    </span>
                                    <h5 class="card-title fw-bold">{{ $f->title }}</h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ Str::limit($f->description, 160) }}
                                    </p>
                                    <div class="mt-3 d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            ⏱ {{ $f->duree_annees }} an{{ $f->duree_annees > 1 ? 's' : '' }}
                                        </small>
                                        <a href="{{ route('formations.show', $f->slug) }}"
                                           class="btn btn-primary btn-sm">
                                            Voir détails →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif
    @endforeach

    {{-- Stats banner --}}
    <div class="row text-center mt-5 py-4 bg-light rounded-3">
        <div class="col-6 col-md-3 mb-3">
            <div class="fs-2 fw-bold text-primary">1980</div>
            <div class="text-muted small">Étudiants</div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="fs-2 fw-bold text-primary">78</div>
            <div class="text-muted small">Professeurs</div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="fs-2 fw-bold text-primary">438</div>
            <div class="text-muted small">Doctorants</div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="fs-2 fw-bold text-primary">3</div>
            <div class="text-muted small">Partenariats internationaux</div>
        </div>
    </div>
</div>

<style>
.formation-card { transition: transform .2s, box-shadow .2s; }
.formation-card:hover { transform: translateY(-4px); box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.12) !important; }
</style>
@endsection
