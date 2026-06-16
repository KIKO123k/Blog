@extends('layouts.app')
@section('title', 'Recherche' . ($q ? ' : ' . $q : ''))

@section('content')
<div class="srch-page">

    <form method="GET" action="{{ route('search') }}" class="srch-bar">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <input type="text" name="q" value="{{ $q }}" placeholder="Rechercher un article, une filière, un club, un étudiant..." autofocus>
        <button type="submit">Rechercher</button>
    </form>

    @if(mb_strlen($q) < 2)
    <div class="srch-hint">Tapez au moins 2 caractères pour lancer la recherche.</div>
    @else
    <p class="srch-summary"><strong>{{ $total }}</strong> résultat(s) pour « <strong>{{ $q }}</strong> »</p>

    @if($total === 0)
    <div class="srch-empty">
        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".25"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        <p>Aucun résultat. Essayez d'autres mots-clés.</p>
    </div>
    @endif

    {{-- Articles --}}
    @if($posts->isNotEmpty())
    <section class="srch-section">
        <h2 class="srch-h2"><span class="srch-tag" style="background:rgba(16,185,129,.12);color:#059669">Articles</span> {{ $posts->count() }}</h2>
        <div class="srch-list">
            @foreach($posts as $p)
            <a href="{{ route('posts.show', $p->slug ?? $p->id) }}" class="srch-item">
                <span class="srch-item-title">{{ $p->title }}</span>
                <span class="srch-item-sub">{{ $p->created_at->format('d M Y') }}@if($p->user) · {{ $p->user->name }}@endif</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Filières --}}
    @if($majors->isNotEmpty())
    <section class="srch-section">
        <h2 class="srch-h2"><span class="srch-tag" style="background:rgba(99,102,241,.12);color:#6366f1">Filières</span> {{ $majors->count() }}</h2>
        <div class="srch-list">
            @foreach($majors as $m)
            <a href="{{ route('majors.show', $m->slug) }}" class="srch-item">
                <span class="srch-item-title">{{ $m->title }}</span>
                <span class="srch-item-sub">{{ \Illuminate\Support\Str::limit($m->description, 80) }}</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Clubs --}}
    @if($clubs->isNotEmpty())
    <section class="srch-section">
        <h2 class="srch-h2"><span class="srch-tag" style="background:rgba(245,158,11,.12);color:#d97706">Clubs</span> {{ $clubs->count() }}</h2>
        <div class="srch-list">
            @foreach($clubs as $c)
            <a href="{{ route('clubs.show', $c) }}" class="srch-item">
                <span class="srch-item-title">{{ $c->acronym }} — {{ $c->name }}</span>
                <span class="srch-item-sub">{{ \Illuminate\Support\Str::limit($c->description, 80) }}</span>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Étudiants --}}
    @if($students->isNotEmpty())
    <section class="srch-section">
        <h2 class="srch-h2"><span class="srch-tag" style="background:rgba(59,130,246,.12);color:#2563eb">Étudiants</span> {{ $students->count() }}</h2>
        <div class="srch-people">
            @foreach($students as $s)
            @php $w = preg_split('/\s+/', trim($s->name)); $ini = strtoupper(mb_substr($w[0],0,1).(isset($w[1])?mb_substr($w[1],0,1):'')); @endphp
            <a href="{{ route('portfolio.show', $s) }}" class="srch-person">
                <span class="srch-person-avatar">{{ $ini }}</span>
                <span class="srch-person-text">
                    <span class="srch-person-name">{{ $s->name }}</span>
                    <span class="srch-person-sub">{{ $s->filiere ?? 'Étudiant ENSA' }}</span>
                </span>
            </a>
            @endforeach
        </div>
    </section>
    @endif
    @endif
</div>

<style>
.srch-page { max-width: 800px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.srch-bar { display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,.85); border: 1.5px solid var(--border-color); border-radius: 16px; padding: 6px 6px 6px 16px; color: var(--text-muted); margin-bottom: 1.5rem; box-shadow: var(--shadow-sm); }
.srch-bar input { flex: 1; border: none; background: none; outline: none; font-size: 1rem; padding: 10px 0; font-family: inherit; color: var(--text-primary); }
.srch-bar button { padding: 10px 20px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 11px; font-weight: 700; font-size: .9rem; cursor: pointer; font-family: inherit; }
.srch-hint, .srch-empty { text-align: center; color: var(--text-muted); padding: 3rem 1rem; }
.srch-empty { display: flex; flex-direction: column; align-items: center; gap: 1rem; }
.srch-summary { font-size: .92rem; color: var(--text-muted); margin-bottom: 1.5rem; }

.srch-section { margin-bottom: 2rem; }
.srch-h2 { display: flex; align-items: center; gap: 10px; font-size: 1rem; font-weight: 800; color: var(--text-primary); margin-bottom: .9rem; }
.srch-tag { font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .04em; padding: 3px 11px; border-radius: 999px; }
.srch-list { display: flex; flex-direction: column; gap: .5rem; }
.srch-item { display: flex; flex-direction: column; gap: 2px; padding: .85rem 1.1rem; background: rgba(255,255,255,.8); border: 1px solid var(--border-color); border-radius: 12px; text-decoration: none; transition: transform .15s, border-color .15s; }
.srch-item:hover { transform: translateX(4px); border-color: rgba(110,231,183,.5); }
.srch-item-title { font-size: .92rem; font-weight: 700; color: var(--text-primary); }
.srch-item-sub { font-size: .78rem; color: var(--text-muted); }

.srch-people { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: .6rem; }
.srch-person { display: flex; align-items: center; gap: 10px; padding: .7rem .85rem; background: rgba(255,255,255,.8); border: 1px solid var(--border-color); border-radius: 12px; text-decoration: none; transition: transform .15s, border-color .15s; }
.srch-person:hover { transform: translateY(-2px); border-color: rgba(110,231,183,.5); }
.srch-person-avatar { width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: .82rem; color: #fff; background: linear-gradient(135deg, #6366f1, #8b5cf6); }
.srch-person-text { display: flex; flex-direction: column; min-width: 0; }
.srch-person-name { font-size: .85rem; font-weight: 700; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.srch-person-sub { font-size: .74rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
</style>
@endsection
