@extends('layouts.app')

@section('title', $major->title)

@section('content')
<div class="container mx-auto p-4">
    <div class="back-link-wrapper">
        <a href="{{ route('majors.index') }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
            Retour aux filières
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-6">
        <!-- COL GAUCHE (2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <header class="post-detail-header p-0 bg-transparent shadow-none border-none">
                <h1 class="post-detail-title gradient-title">{{ $major->title }}</h1>
                <div class="flex gap-4 mt-4">
                    <span class="badge badge-primary bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $major->duree_annees }} ans</span>
                    <span class="badge badge-secondary bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $major->category_label }}</span>
                </div>
            </header>

            <section class="glass p-6 rounded-2xl">
                <h2 class="text-2xl font-bold mb-4">Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $major->description }}</p>
            </section>

            @if(!empty($major->objectifs))
            <section class="glass p-6 rounded-2xl">
                <h2 class="text-2xl font-bold mb-4" style="color: #16a34a; display: flex; align-items: center; gap: 8px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    Objectifs de la formation
                </h2>
                <ul class="space-y-3">
                    @foreach($major->objectifs as $objectif)
                        <li style="display: flex; align-items: flex-start; gap: 10px;">
                            <span style="color: #16a34a; font-weight: bold; font-size: 1.1rem; line-height: 1;">✓</span>
                            <span class="text-gray-700">{{ $objectif }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>
            @endif

            @if(!empty($major->competences))
            <section class="glass p-6 rounded-2xl">
                <h2 class="text-2xl font-bold mb-4" style="color: #16a34a; display: flex; align-items: center; gap: 8px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Compétences visées
                </h2>
                @if(is_array(array_values($major->competences)[0] ?? null))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($major->competences as $group => $items)
                            <div class="bg-white/40 p-4 rounded-xl border border-white/20">
                                <h3 class="font-bold text-gray-800 border-b border-gray-200 pb-2 mb-3">{{ $group }}</h3>
                                <ul class="space-y-2">
                                    @foreach($items as $item)
                                        <li class="text-sm text-gray-600" style="display: flex; align-items: flex-start; gap: 6px;">
                                            <span style="color: #16a34a;">•</span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @else
                    <ul class="space-y-2">
                        @foreach($major->competences as $item)
                            <li class="text-gray-700" style="display: flex; align-items: flex-start; gap: 8px;">
                                <span style="color: #16a34a; font-weight: bold;">•</span>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
            @endif

            @if(!empty($major->programme))
            <section class="glass p-6 rounded-2xl">
                <h2 class="text-2xl font-bold mb-4" style="color: #16a34a; display: flex; align-items: center; gap: 8px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                    Programme d'études
                </h2>
                <div class="space-y-4">
                    @foreach($major->programme as $semester => $modules)
                        <div class="bg-white/40 rounded-xl border border-white/20 overflow-hidden">
                            <div class="bg-green/10 px-4 py-3 border-b border-white/20 font-bold text-gray-800" style="background-color: rgba(34, 197, 94, 0.08);">
                                {{ $semester }}
                            </div>
                            <div class="p-4 flex flex-wrap gap-2">
                                @foreach($modules as $module)
                                    <span class="bg-white/80 border border-gray-200/50 px-3 py-1.5 rounded-lg text-xs text-gray-700 shadow-sm">{{ $module }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

            @if(!empty($major->debouches))
            <section class="glass p-6 rounded-2xl">
                <h2 class="text-2xl font-bold mb-4" style="color: #16a34a; display: flex; align-items: center; gap: 8px;">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Débouchés professionnels
                </h2>
                @if(is_array(array_values($major->debouches)[0] ?? null))
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($major->debouches as $group => $items)
                            <div class="bg-white/40 p-4 rounded-xl border border-white/20">
                                <h3 class="font-bold text-gray-800 border-b border-gray-200 pb-2 mb-3">{{ $group }}</h3>
                                <ul class="space-y-2">
                                    @foreach($items as $item)
                                        <li class="text-sm text-gray-600" style="display: flex; align-items: flex-start; gap: 6px;">
                                            <span style="color: #2563eb;">➔</span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @else
                    <ul class="space-y-2">
                        @foreach($major->debouches as $item)
                            <li class="text-gray-700" style="display: flex; align-items: flex-start; gap: 8px;">
                                <span style="color: #2563eb; font-weight: bold;">➔</span>
                                <span>{{ $item }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
            @endif

            <!-- SECTION COMMENTAIRES -->
            <section class="comments-section mt-12">
                <h2 class="comments-title">Commentaires ({{ $major->comments->count() }})</h2>
                
                @auth
                <div class="comment-form-wrapper glass mb-8">
                    <form action="{{ route('majors.comments.store', $major->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <textarea name="content" class="form-control" required placeholder="Que pensez-vous de cette filière ?" style="min-height: 100px;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Commenter</button>
                    </form>
                </div>
                @else
                <div class="glass p-4 text-center mb-8">
                    <a href="{{ route('login') }}" class="text-primary font-bold">Connectez-vous pour commenter</a>
                </div>
                @endauth

                <div class="comments-list space-y-4">
                    @foreach($major->comments as $comment)
                        <div class="comment-card glass p-4">
                            <div class="comment-header flex items-center gap-3 mb-2">
                                <span class="author-avatar w-10 h-10 flex items-center justify-center bg-primary text-white rounded-full font-bold">
                                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                </span>
                                <div>
                                    <p class="font-bold">{{ $comment->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="comment-body">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>

        <!-- COL DROITE (1/3) -->
        <div class="space-y-6">
            @if(!empty($major->acces))
            <div class="glass p-6 rounded-2xl">
                <h3 class="text-lg font-bold mb-3" style="color: #16a34a;">Conditions d'accès</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    @foreach($major->acces as $cond)
                        <li style="display: flex; align-items: flex-start; gap: 6px;">
                            <span style="color: #16a34a; font-weight: bold;">✓</span>
                            <span>{{ $cond }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(!empty($major->partenariats))
            <div class="glass p-6 rounded-2xl">
                <h3 class="text-lg font-bold mb-3" style="color: #16a34a;">Partenariats</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    @foreach($major->partenariats as $part)
                        <li style="display: flex; align-items: flex-start; gap: 6px;">
                            <span style="color: #eab308;">★</span>
                            <span>{{ $part }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if($major->source_url)
            <div class="glass p-6 rounded-2xl">
                <h3 class="text-lg font-bold mb-3" style="color: #16a34a;">Site officiel</h3>
                <a href="{{ $major->source_url }}" target="_blank" rel="noopener noreferrer" class="btn btn-primary w-full text-center" style="display: block; text-decoration: none; padding: 12px; border-radius: 12px; background-color: #22c55e; border-color: #22c55e; color: white;">
                    Visiter le site officiel
                </a>
            </div>
            @endif

            <div class="glass p-4 rounded-2xl">
                <h3 class="text-lg font-bold mb-4">Vidéo de présentation</h3>
                @if($major->video_path)
                    <video controls class="w-full rounded-xl shadow-lg">
                        <source src="{{ asset('storage/' . $major->video_path) }}" type="video/mp4">
                        Votre navigateur ne supporte pas la lecture de vidéos.
                    </video>
                @else
                    <div class="aspect-video bg-gray-200 rounded-xl flex items-center justify-center text-gray-500 text-center p-4">
                        <p>Vidéo bientôt disponible</p>
                    </div>
                @endif
            </div>

            <div class="glass p-6 rounded-2xl text-center">
                <h3 class="text-lg font-bold mb-2">Note moyenne</h3>
                <div class="flex justify-center items-center gap-2 mb-4">
                    @php $avg = $major->avgRating(); @endphp
                    @if($avg > 0)
                        <div class="post-rating" style="justify-content: center;">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="star-icon {{ $i <= round($avg) ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor" style="width: 24px; height: 24px;">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-2xl font-bold">{{ number_format($avg, 1) }}/5</span>
                    @else
                        <p class="text-muted italic">Pas encore noté</p>
                    @endif
                </div>

                @auth
                <hr class="my-4 border-white/20">
                <p class="mb-3 font-medium">Votre note</p>
                <form action="{{ route('majors.rate', $major->id) }}" method="POST" id="rating-form">
                    @csrf
                    <input type="hidden" name="rating" id="selected-rating" value="{{ $userRating->rating ?? 0 }}">
                    <div class="flex justify-center gap-1">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $i }})" class="star-btn">
                                <svg id="star-{{ $i }}" class="star-icon cursor-pointer {{ ($userRating && $userRating->rating >= $i) ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor" style="width: 32px; height: 32px;">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            </button>
                        @endfor
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mt-4">Enregistrer ma note</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-sm text-primary font-bold">Connectez-vous pour noter</a>
                @endauth
            </div>
        </div>
    </div>
</div>

<script>
function setRating(val) {
    document.getElementById('selected-rating').value = val;
    for(let i=1; i<=5; i++) {
        const star = document.getElementById('star-'+i);
        if(i <= val) star.classList.remove('empty');
        else star.classList.add('empty');
    }
}
</script>
@endsection
