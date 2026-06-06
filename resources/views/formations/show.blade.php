@extends('layouts.app')

@section('title', $formation->title . ' – ENSA Kénitra')

@section('content')
<div class="container py-5">

    {{-- Breadcrumb --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formations.index') }}">Formations</a></li>
            <li class="breadcrumb-item"><a href="{{ route('formations.index', ['category' => $formation->category]) }}">{{ $formation->category_label }}</a></li>
            <li class="breadcrumb-item active">{{ $formation->title }}</li>
        </ol>
    </nav>

    {{-- Hero --}}
    <div class="p-4 p-md-5 mb-5 rounded-3 text-white" style="background: linear-gradient(135deg,#0d6efd 0%,#0a58ca 100%);">
        <span class="badge bg-white text-primary mb-3">{{ $formation->category_label }}</span>
        <h1 class="display-6 fw-bold">{{ $formation->title }}</h1>
        <p class="fs-5 mb-3 opacity-90">{{ $formation->description }}</p>
        <div class="d-flex flex-wrap gap-3">
            <span class="badge bg-white text-dark px-3 py-2">
                ⏱ Durée : {{ $formation->duree_annees }} an{{ $formation->duree_annees > 1 ? 's' : '' }}
            </span>
            <a href="{{ $formation->source_url }}" target="_blank"
               class="badge bg-white text-primary px-3 py-2 text-decoration-none">
                🌐 Source officielle ENSA
            </a>
        </div>
    </div>

    <div class="row g-4">
        {{-- Left column --}}
        <div class="col-lg-8">

            {{-- Objectifs --}}
            @if(!empty($formation->objectifs))
            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3">🎯 Objectifs de la formation</h2>
                <ul class="list-group list-group-flush">
                    @foreach($formation->objectifs as $obj)
                        <li class="list-group-item ps-0 border-0 d-flex gap-2">
                            <span class="text-primary">✓</span> {{ $obj }}
                        </li>
                    @endforeach
                </ul>
            </section>
            @endif

            {{-- Compétences --}}
            @if(!empty($formation->competences))
            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3">🧠 Compétences à acquérir</h2>
                @if(is_array(array_values($formation->competences)[0]))
                    @foreach($formation->competences as $group => $items)
                        <div class="mb-3">
                            <h6 class="fw-semibold text-primary">{{ $group }}</h6>
                            <ul class="mb-0">
                                @foreach($items as $item)
                                    <li>{{ $item }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @else
                    <ul>
                        @foreach($formation->competences as $comp)
                            <li>{{ $comp }}</li>
                        @endforeach
                    </ul>
                @endif
            </section>
            @endif

            {{-- Programme --}}
            @if(!empty($formation->programme))
            <section class="mb-5">
                <h2 class="h4 fw-bold mb-3">📚 Contenu de la formation</h2>
                <div class="accordion" id="programmeAccordion">
                    @foreach($formation->programme as $semester => $modules)
                        @php $acId = Str::slug($semester) @endphp
                        <div class="accordion-item border mb-2 rounded-2 overflow-hidden">
                            <h3 class="accordion-header">
                                <button class="accordion-button collapsed fw-semibold" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#{{ $acId }}"
                                        aria-expanded="false">
                                    {{ $semester }}
                                </button>
                            </h3>
                            <div id="{{ $acId }}" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <ul class="mb-0">
                                        @foreach($modules as $module)
                                            <li>{{ $module }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

        </div>

        {{-- Right sidebar --}}
        <div class="col-lg-4">

            {{-- Débouchés --}}
            @if(!empty($formation->debouches))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">💼 Débouchés professionnels</h5>
                    @if(is_array(array_values($formation->debouches)[0]))
                        @foreach($formation->debouches as $domain => $jobs)
                            <p class="fw-semibold text-primary mb-1">{{ $domain }}</p>
                            <ul class="small mb-2">
                                @foreach($jobs as $job)
                                    <li>{{ $job }}</li>
                                @endforeach
                            </ul>
                        @endforeach
                    @else
                        <ul class="list-unstyled mb-0">
                            @foreach($formation->debouches as $d)
                                <li class="mb-1">🔹 {{ $d }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
            @endif

            {{-- Conditions d'accès --}}
            @if(!empty($formation->acces))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">📋 Conditions d'accès</h5>
                    <ul class="list-unstyled mb-0 small">
                        @foreach($formation->acces as $a)
                            <li class="mb-2">✅ {{ $a }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Partenariats --}}
            @if(!empty($formation->partenariats))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">🤝 Double diplôme & Mobilité</h5>
                    <ul class="list-unstyled mb-0 small">
                        @foreach($formation->partenariats as $p)
                            <li class="mb-1">🎓 {{ $p }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- CTA --}}
            <div class="card border-primary border-2 bg-primary bg-opacity-10">
                <div class="card-body text-center">
                    <h6 class="fw-bold mb-2">Intéressé par cette formation ?</h6>
                    <a href="https://ensa.uit.ac.ma/ensa-access/" target="_blank"
                       class="btn btn-primary btn-sm w-100 mb-2">
                        📝 Conditions d'admission
                    </a>
                    <a href="https://ensa.uit.ac.ma/contact/" target="_blank"
                       class="btn btn-outline-primary btn-sm w-100">
                        📧 Contacter l'ENSA
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- Back link --}}
    <div class="mt-4">
        <a href="{{ route('formations.index') }}" class="btn btn-light">
            ← Retour aux formations
        </a>
    </div>

</div>
@endsection
