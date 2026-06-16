@extends('layouts.app')
@section('title', 'Trouver des coéquipiers')

@section('content')
<div class="eco-wide">
    <div class="eco-head">
        <span class="eco-eyebrow" style="color:#6366f1">Espace Étudiant</span>
        <h1 class="eco-title">Trouver des <span class="gradient-title">coéquipiers</span></h1>
        <p class="eco-subtitle">Publiez une annonce ou rejoignez une équipe pour vos projets, hackathons et PFE.</p>
    </div>

    @auth
    <details class="eco-form-card">
        <summary>+ Publier une annonce de recherche</summary>
        <form method="POST" action="{{ route('ecosystem.teammates.store') }}" class="eco-form-grid">
            @csrf
            <div class="eco-field eco-full">
                <label>Titre du projet *</label>
                <input type="text" name="title" required placeholder="Ex. App mobile de covoiturage étudiant">
            </div>
            <div class="eco-field eco-full">
                <label>Description *</label>
                <textarea name="description" rows="3" required placeholder="Décrivez le projet et ce que vous cherchez..."></textarea>
            </div>
            <div class="eco-field">
                <label>Compétences recherchées (virgules)</label>
                <input type="text" name="skills_needed" placeholder="Flutter, UI/UX, Backend">
            </div>
            <div class="eco-field">
                <label>Filière</label>
                <input type="text" name="filiere" value="{{ auth()->user()->filiere }}" placeholder="Génie Informatique">
            </div>
            <div class="eco-field">
                <label>Taille de l'équipe</label>
                <input type="number" name="team_size" min="2" max="10" value="3">
            </div>
            <div class="eco-full"><button type="submit" class="eco-submit">Publier l'annonce</button></div>
        </form>
    </details>
    @endauth

    {{-- Filtres --}}
    <form method="GET" class="eco-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un projet, une compétence...">
        <select name="filiere" onchange="this.form.submit()">
            <option value="">Toutes filières</option>
            @foreach($filieres as $f)<option value="{{ $f }}" @selected(request('filiere')===$f)>{{ $f }}</option>@endforeach
        </select>
        <button type="submit">Filtrer</button>
    </form>

    @if($posts->isEmpty())
    <div class="eco-empty">Aucune annonce pour le moment. Soyez le premier à publier !</div>
    @else
    <div class="eco-grid">
        @foreach($posts as $post)
        <div class="tm-card">
            <div class="tm-top">
                <a href="{{ route('portfolio.show', $post->user) }}" class="tm-author">
                    <span class="tm-avatar">{{ strtoupper(mb_substr($post->user->name,0,1)) }}</span>
                    <span>
                        <span class="tm-author-name">{{ $post->user->name }}</span>
                        <span class="tm-author-sub">{{ $post->filiere ?? ($post->user->filiere ?? 'ENSA') }}</span>
                    </span>
                </a>
                <span class="tm-size">👥 {{ $post->team_size }}</span>
            </div>
            <h3 class="tm-title">{{ $post->title }}</h3>
            <p class="tm-desc">{{ \Illuminate\Support\Str::limit($post->description, 130) }}</p>
            @if($post->skillsList())
            <div class="tm-skills">
                @foreach($post->skillsList() as $skill)<span class="tm-skill">{{ $skill }}</span>@endforeach
            </div>
            @endif
            <div class="tm-actions">
                @auth
                    @if($post->user_id === auth()->id())
                    <form method="POST" action="{{ route('ecosystem.teammates.close', $post) }}"><?php /* owner */ ?>@csrf<button class="tm-btn tm-close">Clôturer</button></form>
                    @else
                    <a href="{{ route('messages.show', $post->user) }}" class="tm-btn tm-contact">Contacter</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="tm-btn tm-contact">Se connecter pour contacter</a>
                @endauth
            </div>
        </div>
        @endforeach
    </div>
    <div class="eco-pagination">{{ $posts->links() }}</div>
    @endif
</div>

<style>
.eco-wide { max-width: 1050px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.eco-head { text-align: center; margin-bottom: 1.75rem; }
.eco-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
.eco-title { font-size: 2rem; font-weight: 900; letter-spacing: -.04em; margin: .3rem 0 .4rem; color: var(--text-primary); }
.eco-subtitle { font-size: .92rem; color: var(--text-muted); max-width: 560px; margin: 0 auto; }

.eco-form-card { background: rgba(255,255,255,.8); border: 1px solid var(--border-color); border-radius: 16px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
.eco-form-card summary { cursor: pointer; font-weight: 800; color: #6366f1; font-size: .92rem; }
.eco-form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .8rem; margin-top: 1rem; }
.eco-field { display: flex; flex-direction: column; gap: 4px; }
.eco-full { grid-column: 1 / -1; }
.eco-field label { font-size: .78rem; font-weight: 700; color: var(--text-muted); }
.eco-field input, .eco-field textarea, .eco-filters select { border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 12px; font-size: .88rem; font-family: inherit; outline: none; }
.eco-field input:focus, .eco-field textarea:focus { border-color: #6366f1; }
.eco-submit { padding: 10px 20px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: inherit; }

.eco-filters { display: flex; gap: .6rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.eco-filters input { flex: 1; min-width: 200px; border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 14px; font-family: inherit; outline: none; }
.eco-filters select { border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 12px; font-family: inherit; background:#fff; }
.eco-filters button { padding: 9px 18px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: inherit; }

.eco-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem; }
.tm-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.25rem; display: flex; flex-direction: column; gap: .6rem; }
.tm-top { display: flex; align-items: center; justify-content: space-between; }
.tm-author { display: flex; align-items: center; gap: 9px; text-decoration: none; }
.tm-avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg,#6366f1,#8b5cf6); color: #fff; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: .85rem; }
.tm-author-name { display: block; font-size: .85rem; font-weight: 700; color: var(--text-primary); }
.tm-author-sub { display: block; font-size: .72rem; color: var(--text-muted); }
.tm-size { font-size: .8rem; color: var(--text-muted); font-weight: 600; }
.tm-title { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin: 0; }
.tm-desc { font-size: .85rem; color: var(--text-muted); line-height: 1.5; margin: 0; flex: 1; }
.tm-skills { display: flex; flex-wrap: wrap; gap: 5px; }
.tm-skill { font-size: .72rem; font-weight: 600; background: rgba(99,102,241,.1); color: #6366f1; padding: 2px 9px; border-radius: 6px; }
.tm-actions { padding-top: .5rem; border-top: 1px solid var(--border-color); }
.tm-btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 9px; font-size: .82rem; font-weight: 700; text-decoration: none; cursor: pointer; border: none; font-family: inherit; }
.tm-contact { background: var(--gradient-primary); color: #0f172a; }
.tm-close { background: rgba(239,68,68,.1); color: #dc2626; }

.eco-empty { text-align: center; padding: 3rem; background: rgba(255,255,255,.5); border: 1.5px dashed var(--border-color); border-radius: 16px; color: var(--text-muted); }
.eco-pagination { margin-top: 1.5rem; display: flex; justify-content: center; }
@media(max-width:600px){ .eco-form-grid { grid-template-columns: 1fr; } }
</style>
@endsection
