@extends('layouts.app')
@section('title', 'Objets perdus & trouvés')

@php
    $cats = ['electronique'=>'Électronique','documents'=>'Documents','cles'=>'Clés','vetements'=>'Vêtements','livres'=>'Livres','autre'=>'Autre'];
@endphp

@section('content')
<div class="eco-wide">
    <div class="eco-head">
        <span class="eco-eyebrow" style="color:#d97706">Espace Étudiant</span>
        <h1 class="eco-title">Objets <span class="gradient-title">perdus & trouvés</span></h1>
        <p class="eco-subtitle">Vous avez perdu ou trouvé quelque chose au campus ? Signalez-le ici pour aider la communauté.</p>
    </div>

    @auth
    <details class="eco-form-card">
        <summary>+ Signaler un objet perdu ou trouvé</summary>
        <form method="POST" action="{{ route('ecosystem.lostfound.store') }}" enctype="multipart/form-data" class="eco-form-grid">
            @csrf
            <div class="eco-field">
                <label>Type *</label>
                <select name="type" required>
                    <option value="lost">J'ai perdu</option>
                    <option value="found">J'ai trouvé</option>
                </select>
            </div>
            <div class="eco-field">
                <label>Catégorie *</label>
                <select name="category" required>
                    @foreach($cats as $k=>$v)<option value="{{ $k }}">{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="eco-field">
                <label>Date</label>
                <input type="date" name="item_date">
            </div>
            <div class="eco-field eco-full">
                <label>Titre *</label>
                <input type="text" name="title" required placeholder="Ex. Carte étudiante au nom de...">
            </div>
            <div class="eco-field eco-full">
                <label>Description</label>
                <textarea name="description" rows="2" placeholder="Détails, couleur, marque, où exactement..."></textarea>
            </div>
            <div class="eco-field">
                <label>Lieu</label>
                <input type="text" name="location" placeholder="Bibliothèque, Amphi A...">
            </div>
            <div class="eco-field">
                <label>Photo</label>
                <input type="file" name="image" accept="image/*">
            </div>
            <div class="eco-full"><button type="submit" class="eco-submit">Publier le signalement</button></div>
        </form>
    </details>
    @endauth

    {{-- Onglets type --}}
    <div class="lf-tabs">
        <a href="{{ route('ecosystem.lostfound') }}" class="lf-tab {{ !request('type') ? 'active' : '' }}">Tout</a>
        <a href="{{ route('ecosystem.lostfound', ['type'=>'lost']) }}" class="lf-tab {{ request('type')==='lost' ? 'active' : '' }}">🔴 Perdus</a>
        <a href="{{ route('ecosystem.lostfound', ['type'=>'found']) }}" class="lf-tab {{ request('type')==='found' ? 'active' : '' }}">🟢 Trouvés</a>
    </div>

    @if($items->isEmpty())
    <div class="eco-empty">Aucun objet signalé pour le moment.</div>
    @else
    <div class="lf-grid">
        @foreach($items as $item)
        <div class="lf-card">
            @if($item->image_path)
            <div class="lf-img"><img src="{{ Storage::url($item->image_path) }}" alt="{{ $item->title }}"></div>
            @endif
            <div class="lf-body">
                <div class="lf-top">
                    <span class="lf-type lf-{{ $item->type }}">{{ $item->type === 'lost' ? 'Perdu' : 'Trouvé' }}</span>
                    <span class="lf-cat">{{ $cats[$item->category] ?? ucfirst($item->category) }}</span>
                </div>
                <h3 class="lf-title">{{ $item->title }}</h3>
                @if($item->description)<p class="lf-desc">{{ \Illuminate\Support\Str::limit($item->description, 90) }}</p>@endif
                <div class="lf-meta">
                    @if($item->location)<span>📍 {{ $item->location }}</span>@endif
                    @if($item->item_date)<span>📅 {{ $item->item_date->format('d/m/Y') }}</span>@endif
                </div>
                <div class="lf-foot">
                    <a href="{{ route('portfolio.show', $item->user) }}" class="lf-owner">par {{ $item->user->name }}</a>
                    @auth
                        @if($item->user_id === auth()->id())
                        <form method="POST" action="{{ route('ecosystem.lostfound.resolve', $item) }}">@csrf<button class="lf-resolve">✓ Résolu</button></form>
                        @else
                        <a href="{{ route('messages.show', $item->user) }}" class="lf-contact">Contacter</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="eco-pagination">{{ $items->links() }}</div>
    @endif
</div>

<style>
.eco-wide { max-width: 1050px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.eco-head { text-align: center; margin-bottom: 1.75rem; }
.eco-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
.eco-title { font-size: 2rem; font-weight: 900; letter-spacing: -.04em; margin: .3rem 0 .4rem; color: var(--text-primary); }
.eco-subtitle { font-size: .92rem; color: var(--text-muted); max-width: 560px; margin: 0 auto; }
.eco-form-card { background: rgba(255,255,255,.8); border: 1px solid var(--border-color); border-radius: 16px; padding: 1rem 1.25rem; margin-bottom: 1.25rem; }
.eco-form-card summary { cursor: pointer; font-weight: 800; color: #d97706; font-size: .92rem; }
.eco-form-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: .8rem; margin-top: 1rem; }
.eco-field { display: flex; flex-direction: column; gap: 4px; }
.eco-full { grid-column: 1 / -1; }
.eco-field label { font-size: .78rem; font-weight: 700; color: var(--text-muted); }
.eco-field input, .eco-field textarea, .eco-field select { border: 1.5px solid var(--border-color); border-radius: 10px; padding: 9px 12px; font-size: .88rem; font-family: inherit; outline: none; background:#fff; }
.eco-field input:focus, .eco-field textarea:focus { border-color: #d97706; }
.eco-submit { padding: 10px 20px; background: linear-gradient(135deg,#fbbf24,#f59e0b); color: #0f172a; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: inherit; }
.eco-empty { text-align: center; padding: 3rem; background: rgba(255,255,255,.5); border: 1.5px dashed var(--border-color); border-radius: 16px; color: var(--text-muted); }
.eco-pagination { margin-top: 1.5rem; display: flex; justify-content: center; }

.lf-tabs { display: flex; gap: .5rem; margin-bottom: 1.5rem; }
.lf-tab { padding: 8px 18px; border-radius: 999px; font-size: .85rem; font-weight: 700; text-decoration: none; color: var(--text-muted); border: 1px solid var(--border-color); }
.lf-tab.active { background: var(--gradient-primary); color: #0f172a; border-color: transparent; }
.lf-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 1rem; }
.lf-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden; display: flex; flex-direction: column; }
.lf-img { height: 140px; background: #f1f5f9; }
.lf-img img { width: 100%; height: 100%; object-fit: cover; }
.lf-body { padding: 1rem; display: flex; flex-direction: column; gap: .5rem; flex: 1; }
.lf-top { display: flex; align-items: center; justify-content: space-between; }
.lf-type { font-size: .7rem; font-weight: 800; text-transform: uppercase; padding: 3px 10px; border-radius: 999px; }
.lf-lost { background: rgba(239,68,68,.1); color: #dc2626; }
.lf-found { background: rgba(16,185,129,.12); color: #059669; }
.lf-cat { font-size: .72rem; color: var(--text-muted); font-weight: 600; }
.lf-title { font-size: .95rem; font-weight: 800; color: var(--text-primary); margin: 0; }
.lf-desc { font-size: .82rem; color: var(--text-muted); line-height: 1.5; margin: 0; flex: 1; }
.lf-meta { display: flex; flex-wrap: wrap; gap: .6rem; font-size: .75rem; color: var(--text-muted); }
.lf-foot { display: flex; align-items: center; justify-content: space-between; padding-top: .5rem; border-top: 1px solid var(--border-color); }
.lf-owner { font-size: .75rem; color: var(--text-muted); text-decoration: none; }
.lf-contact { font-size: .78rem; font-weight: 700; color: #0284c7; text-decoration: none; }
.lf-resolve { font-size: .76rem; font-weight: 700; color: #059669; background: rgba(16,185,129,.1); border: none; border-radius: 8px; padding: 5px 11px; cursor: pointer; font-family: inherit; }
@media(max-width:600px){ .eco-form-grid { grid-template-columns: 1fr; } }
</style>
@endsection
