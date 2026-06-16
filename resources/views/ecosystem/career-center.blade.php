@extends('layouts.app')
@section('title', 'Career Center')

@php
    $typeMeta = ['stage'=>['Stage','#6366f1'],'pfe'=>['PFE','#dc2626'],'emploi'=>['Emploi','#059669'],'alternance'=>['Alternance','#d97706']];
@endphp

@section('content')
<div class="eco-wide">
    <div class="eco-head">
        <span class="eco-eyebrow" style="color:#059669">Espace Étudiant</span>
        <h1 class="eco-title">Career <span class="gradient-title">Center</span></h1>
        <p class="eco-subtitle">Offres de stages, PFE et emplois publiées par les recruteurs partenaires, et conseils carrière.</p>
    </div>

    @if($canPost)
    <details class="eco-form-card">
        <summary>+ Publier une offre</summary>
        <form method="POST" action="{{ route('ecosystem.career.store') }}" class="eco-form-grid">
            @csrf
            <div class="eco-field"><label>Intitulé *</label><input type="text" name="title" required placeholder="Développeur Full-Stack"></div>
            <div class="eco-field"><label>Entreprise *</label><input type="text" name="company" required placeholder="OCP, Capgemini..."></div>
            <div class="eco-field"><label>Type *</label><select name="type" required><option value="stage">Stage</option><option value="pfe">PFE</option><option value="emploi">Emploi</option><option value="alternance">Alternance</option></select></div>
            <div class="eco-field"><label>Lieu</label><input type="text" name="location" placeholder="Casablanca, Remote..."></div>
            <div class="eco-field"><label>Domaine</label><input type="text" name="domain" placeholder="Informatique, Génie Industriel..."></div>
            <div class="eco-field"><label>Lien de candidature</label><input type="url" name="apply_url" placeholder="https://..."></div>
            <div class="eco-field eco-full"><label>Description</label><textarea name="description" rows="3" placeholder="Missions, profil recherché..."></textarea></div>
            <div class="eco-full"><button type="submit" class="eco-submit">Publier l'offre</button></div>
        </form>
    </details>
    @endif

    {{-- Filtres --}}
    <form method="GET" class="eco-filters">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une offre, une entreprise...">
        <select name="type" onchange="this.form.submit()">
            <option value="">Tous types</option>
            <option value="stage" @selected(request('type')==='stage')>Stage</option>
            <option value="pfe" @selected(request('type')==='pfe')>PFE</option>
            <option value="emploi" @selected(request('type')==='emploi')>Emploi</option>
            <option value="alternance" @selected(request('type')==='alternance')>Alternance</option>
        </select>
        <button type="submit">Filtrer</button>
    </form>

    @if($offers->isEmpty())
    <div class="eco-empty">Aucune offre pour le moment. Les recruteurs vérifiés peuvent en publier.</div>
    @else
    <div class="cc-list">
        @foreach($offers as $offer)
        @php [$tl,$tc] = $typeMeta[$offer->type] ?? ['Offre','#6366f1']; @endphp
        <div class="cc-card">
            <div class="cc-logo" style="background: {{ $tc }}1a; color: {{ $tc }};">{{ strtoupper(mb_substr($offer->company,0,2)) }}</div>
            <div class="cc-body">
                <div class="cc-top">
                    <span class="cc-type" style="background: {{ $tc }}1a; color: {{ $tc }};">{{ $tl }}</span>
                    @if($offer->domain)<span class="cc-domain">{{ $offer->domain }}</span>@endif
                </div>
                <h3 class="cc-title">{{ $offer->title }}</h3>
                <p class="cc-company">{{ $offer->company }}@if($offer->location) · 📍 {{ $offer->location }}@endif</p>
                @if($offer->description)<p class="cc-desc">{{ \Illuminate\Support\Str::limit($offer->description, 140) }}</p>@endif
            </div>
            @if($offer->apply_url)
            <a href="{{ $offer->apply_url }}" target="_blank" rel="noopener" class="cc-apply">Postuler →</a>
            @endif
        </div>
        @endforeach
    </div>
    <div class="eco-pagination">{{ $offers->links() }}</div>
    @endif

    {{-- Conseils carrière --}}
    <div class="cc-tips">
        <h2>💡 Conseils carrière</h2>
        <div class="cc-tips-grid">
            <div class="cc-tip"><strong>CV percutant</strong><span>Une page, des verbes d'action, des résultats chiffrés. Générez-le depuis votre portfolio (bouton « CV PDF »).</span></div>
            <div class="cc-tip"><strong>LinkedIn optimisé</strong><span>Photo pro, titre clair, projets épinglés. Reliez votre profil depuis votre portfolio.</span></div>
            <div class="cc-tip"><strong>Préparer l'entretien</strong><span>Renseignez l'entreprise, préparez le STAR, et entraînez-vous aux questions techniques de votre filière.</span></div>
        </div>
    </div>
</div>

<style>
.eco-wide { max-width: 920px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.eco-head { text-align: center; margin-bottom: 1.75rem; }
.eco-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
.eco-title { font-size: 2rem; font-weight: 900; letter-spacing: -.04em; margin: .3rem 0 .4rem; color: var(--text-primary); }
.eco-subtitle { font-size: .92rem; color: var(--text-muted); max-width: 560px; margin: 0 auto; }
.eco-form-card { background: rgba(255,255,255,.8); border: 1px solid var(--border-color); border-radius: 16px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
.eco-form-card summary { cursor: pointer; font-weight: 800; color: #059669; font-size: .92rem; }
.eco-form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .8rem; margin-top: 1rem; }
.eco-field { display: flex; flex-direction: column; gap: 4px; }
.eco-full { grid-column: 1 / -1; }
.eco-field label { font-size: .78rem; font-weight: 700; color: var(--text-muted); }
.eco-field input, .eco-field textarea, .eco-field select { border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 12px; font-size: .88rem; font-family: inherit; outline: none; background:#fff; }
.eco-submit { padding: 10px 20px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: inherit; }
.eco-filters { display: flex; gap: .6rem; margin-bottom: 1.5rem; flex-wrap: wrap; }
.eco-filters input { flex: 1; min-width: 200px; border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 14px; font-family: inherit; outline: none; }
.eco-filters select { border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 12px; font-family: inherit; background:#fff; }
.eco-filters button { padding: 9px 18px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: inherit; }
.eco-empty { text-align: center; padding: 3rem; background: rgba(255,255,255,.5); border: 1.5px dashed var(--border-color); border-radius: 16px; color: var(--text-muted); }
.eco-pagination { margin-top: 1.5rem; display: flex; justify-content: center; }

.cc-list { display: flex; flex-direction: column; gap: .8rem; }
.cc-card { display: flex; align-items: center; gap: 1rem; background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.1rem; }
.cc-logo { width: 52px; height: 52px; border-radius: 13px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1rem; flex-shrink: 0; }
.cc-body { flex: 1; min-width: 0; }
.cc-top { display: flex; align-items: center; gap: 8px; margin-bottom: 3px; }
.cc-type { font-size: .68rem; font-weight: 800; text-transform: uppercase; padding: 2px 9px; border-radius: 999px; }
.cc-domain { font-size: .72rem; color: var(--text-muted); }
.cc-title { font-size: 1rem; font-weight: 800; color: var(--text-primary); margin: 0; }
.cc-company { font-size: .82rem; color: var(--text-muted); margin: 2px 0 0; }
.cc-desc { font-size: .82rem; color: var(--text-muted); line-height: 1.5; margin: .4rem 0 0; }
.cc-apply { flex-shrink: 0; padding: 9px 18px; background: var(--gradient-primary); color: #0f172a; border-radius: 10px; font-weight: 700; font-size: .82rem; text-decoration: none; white-space: nowrap; }

.cc-tips { margin-top: 2.5rem; }
.cc-tips h2 { font-size: 1.2rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1rem; }
.cc-tips-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px,1fr)); gap: 1rem; }
.cc-tip { background: rgba(255,255,255,.7); border: 1px solid var(--border-color); border-radius: 14px; padding: 1.1rem; display: flex; flex-direction: column; gap: 5px; }
.cc-tip strong { font-size: .92rem; color: var(--text-primary); }
.cc-tip span { font-size: .83rem; color: var(--text-muted); line-height: 1.55; }
@media(max-width:600px){ .eco-form-grid { grid-template-columns: 1fr; } .cc-card { flex-wrap: wrap; } }
</style>
@endsection
