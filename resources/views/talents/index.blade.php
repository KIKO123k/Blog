@extends('layouts.app')
@section('title', 'Annuaire des talents')

@section('content')
<div class="tal-page">

    <div class="tal-header">
        <span class="tal-eyebrow">Espace recruteur</span>
        <h1 class="tal-title">Annuaire des <span class="gradient-title">talents</span></h1>
        <p class="tal-subtitle">Parcourez les profils des étudiants ingénieurs de l'ENSA Kénitra. Cliquez sur un profil pour voir son portfolio complet et son CV.</p>
    </div>

    {{-- Filtres --}}
    <form method="GET" class="tal-filters">
        <div class="tal-search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un nom, une compétence...">
        </div>
        <select name="filiere" class="tal-select" onchange="this.form.submit()">
            <option value="">Toutes les filières</option>
            @foreach($filieres as $f)
            <option value="{{ $f }}" @selected(request('filiere') === $f)>{{ $f }}</option>
            @endforeach
        </select>
        <select name="promotion" class="tal-select" onchange="this.form.submit()">
            <option value="">Toutes promotions</option>
            @foreach($promotions as $p)
            <option value="{{ $p }}" @selected((string) request('promotion') === (string) $p)>Promo {{ $p }}</option>
            @endforeach
        </select>
        <label class="tal-cv-toggle">
            <input type="checkbox" name="with_cv" value="1" @checked(request('with_cv')) onchange="this.form.submit()">
            Avec CV
        </label>
        <button type="submit" class="tal-search-btn">Rechercher</button>
    </form>

    <div class="tal-count">{{ $students->total() }} étudiant(s) trouvé(s)</div>

    {{-- Grille --}}
    @if($students->isEmpty())
    <div class="tal-empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".25"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <p>Aucun étudiant ne correspond à ces critères.</p>
    </div>
    @else
    <div class="tal-grid">
        @foreach($students as $s)
        @php $w = preg_split('/\s+/', trim($s->name)); $ini = strtoupper(mb_substr($w[0],0,1).(isset($w[1])?mb_substr($w[1],0,1):'')); @endphp
        <a href="{{ route('portfolio.show', $s) }}" class="tal-card">
            <div class="tal-card-top">
                @if($s->avatar_path)
                    <img src="{{ Storage::url($s->avatar_path) }}" alt="{{ $s->name }}" class="tal-avatar-img">
                @else
                    <span class="tal-avatar">{{ $ini }}</span>
                @endif
                @if($s->cv_path)<span class="tal-cv-badge">CV</span>@endif
            </div>
            <h3 class="tal-name">{{ $s->name }}</h3>
            <p class="tal-filiere">{{ $s->filiere ?? 'Étudiant ENSA' }}@if($s->promotion) · {{ $s->promotion }}@endif</p>
            @if($s->bio)<p class="tal-bio">{{ Str::limit($s->bio, 90) }}</p>@endif
            <div class="tal-stats">
                <span><strong>{{ $s->projects_count }}</strong> projets</span>
                <span><strong>{{ $s->internships_count }}</strong> stages</span>
            </div>
        </a>
        @endforeach
    </div>
    <div class="tal-pagination">{{ $students->links() }}</div>
    @endif
</div>

<style>
.tal-page { max-width: 1150px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.tal-header { text-align: center; margin-bottom: 2rem; }
.tal-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; color: #6366f1; }
.tal-title { font-size: 2.1rem; font-weight: 900; letter-spacing: -.04em; margin: .3rem 0 .4rem; color: var(--text-primary); }
.tal-subtitle { font-size: .92rem; color: var(--text-muted); max-width: 620px; margin: 0 auto; }

.tal-filters { display: flex; flex-wrap: wrap; gap: .6rem; align-items: center; background: rgba(255,255,255,.7); border: 1px solid var(--border-color); border-radius: 16px; padding: .8rem; margin-bottom: 1rem; }
.tal-search { flex: 1; min-width: 200px; display: flex; align-items: center; gap: 8px; padding: 0 12px; background: var(--bg-tertiary, rgba(15,23,42,.04)); border-radius: 10px; color: var(--text-muted); }
.tal-search input { flex: 1; border: none; background: none; outline: none; padding: 10px 0; font-size: .9rem; font-family: inherit; color: var(--text-primary); }
.tal-select { padding: 9px 12px; border: 1px solid var(--border-color); border-radius: 10px; background: #fff; font-size: .85rem; font-family: inherit; color: var(--text-primary); cursor: pointer; }
.tal-cv-toggle { display: flex; align-items: center; gap: 6px; font-size: .85rem; font-weight: 600; color: var(--text-secondary); cursor: pointer; padding: 0 6px; }
.tal-search-btn { padding: 9px 18px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 10px; font-weight: 700; font-size: .85rem; cursor: pointer; font-family: inherit; }
.tal-count { font-size: .82rem; color: var(--text-muted); margin-bottom: 1.25rem; font-weight: 600; }

.tal-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.1rem; }
.tal-card { display: flex; flex-direction: column; background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 18px; padding: 1.3rem; text-decoration: none; transition: transform .2s, box-shadow .2s, border-color .2s; }
.tal-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: rgba(110,231,183,.5); }
.tal-card-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: .9rem; }
.tal-avatar, .tal-avatar-img { width: 58px; height: 58px; border-radius: 50%; }
.tal-avatar { display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 800; color: #fff; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.tal-avatar-img { object-fit: cover; }
.tal-cv-badge { font-size: .68rem; font-weight: 800; color: #059669; background: rgba(16,185,129,.12); border: 1px solid rgba(16,185,129,.25); padding: 3px 9px; border-radius: 999px; }
.tal-name { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin: 0 0 2px; }
.tal-filiere { font-size: .8rem; font-weight: 600; color: #6366f1; margin: 0 0 .6rem; }
.tal-bio { font-size: .82rem; color: var(--text-muted); line-height: 1.55; margin: 0 0 .9rem; flex: 1; }
.tal-stats { display: flex; gap: 1rem; padding-top: .8rem; border-top: 1px solid var(--border-color); }
.tal-stats span { font-size: .78rem; color: var(--text-muted); }
.tal-stats strong { color: var(--text-primary); }

.tal-empty { text-align: center; padding: 4rem 1rem; color: var(--text-muted); display: flex; flex-direction: column; align-items: center; gap: 1rem; }
.tal-pagination { margin-top: 2rem; display: flex; justify-content: center; }
@media (max-width: 600px) { .tal-filters { flex-direction: column; align-items: stretch; } }
</style>
@endsection
