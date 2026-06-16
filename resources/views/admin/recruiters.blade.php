@extends('layouts.app')
@section('title', 'Vérification des recruteurs')

@section('content')
<div class="adr-page">

    <div class="adr-header">
        <span class="adr-eyebrow">Administration</span>
        <h1 class="adr-title">Vérification des recruteurs</h1>
        <p class="adr-subtitle">Examinez les badges professionnels et approuvez les recruteurs autorisés à consulter les CV des étudiants.</p>
    </div>

    @if(session('success'))
    <div class="adr-alert">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats --}}
    <div class="adr-stats">
        <div class="adr-stat"><span class="adr-stat-num" style="color:#d97706">{{ $pending->count() }}</span><span class="adr-stat-label">En attente</span></div>
        <div class="adr-stat"><span class="adr-stat-num" style="color:#059669">{{ $approved->count() }}</span><span class="adr-stat-label">Approuvés</span></div>
        <div class="adr-stat"><span class="adr-stat-num" style="color:#dc2626">{{ $rejected->count() }}</span><span class="adr-stat-label">Refusés</span></div>
    </div>

    {{-- PENDING --}}
    <section class="adr-section">
        <h2 class="adr-section-title">
            <span class="adr-dot" style="background:#f59e0b"></span>
            Demandes en attente
        </h2>

        @if($pending->isEmpty())
        <div class="adr-empty">
            <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            <p>Aucune demande en attente. Tout est à jour !</p>
        </div>
        @else
        <div class="adr-grid">
            @foreach($pending as $recruiter)
            <div class="adr-card">
                <div class="adr-badge-wrap">
                    @if($recruiter->badge_path)
                    <a href="{{ route('admin.recruiters.badge', $recruiter) }}" target="_blank" title="Voir en grand">
                        <img src="{{ route('admin.recruiters.badge', $recruiter) }}" alt="Badge de {{ $recruiter->name }}" class="adr-badge-img">
                        <span class="adr-badge-zoom">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><line x1="11" y1="8" x2="11" y2="14"/><line x1="8" y1="11" x2="14" y2="11"/></svg>
                        </span>
                    </a>
                    @else
                    <div class="adr-badge-missing">Aucun badge fourni</div>
                    @endif
                </div>
                <div class="adr-card-body">
                    <h3 class="adr-name">{{ $recruiter->name }}</h3>
                    <div class="adr-meta-row">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        <strong>{{ $recruiter->company_name ?? '—' }}</strong>
                    </div>
                    <div class="adr-meta-row">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <a href="mailto:{{ $recruiter->email }}">{{ $recruiter->email }}</a>
                    </div>
                    <span class="adr-time">Inscrit {{ $recruiter->created_at->diffForHumans() }}</span>

                    <div class="adr-actions">
                        <form action="{{ route('admin.recruiters.approve', $recruiter) }}" method="POST">
                            @csrf
                            <button type="submit" class="adr-btn adr-btn-approve">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                Approuver
                            </button>
                        </form>
                        <form action="{{ route('admin.recruiters.reject', $recruiter) }}" method="POST" onsubmit="return confirm('Refuser ce recruteur ?')">
                            @csrf
                            <button type="submit" class="adr-btn adr-btn-reject">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Refuser
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>

    {{-- APPROVED --}}
    @if($approved->isNotEmpty())
    <section class="adr-section">
        <h2 class="adr-section-title"><span class="adr-dot" style="background:#059669"></span>Recruteurs approuvés</h2>
        <div class="adr-list">
            @foreach($approved as $recruiter)
            <div class="adr-row">
                <div class="adr-row-info">
                    <span class="adr-row-name">{{ $recruiter->name }}</span>
                    <span class="adr-row-company">{{ $recruiter->company_name }} · {{ $recruiter->email }}</span>
                </div>
                <div class="adr-row-actions">
                    <span class="adr-status adr-status-ok">✓ Approuvé</span>
                    <form action="{{ route('admin.recruiters.reject', $recruiter) }}" method="POST" onsubmit="return confirm('Révoquer l\'accès de ce recruteur ?')">
                        @csrf
                        <button type="submit" class="adr-mini-btn">Révoquer</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- REJECTED --}}
    @if($rejected->isNotEmpty())
    <section class="adr-section">
        <h2 class="adr-section-title"><span class="adr-dot" style="background:#dc2626"></span>Demandes refusées</h2>
        <div class="adr-list">
            @foreach($rejected as $recruiter)
            <div class="adr-row">
                <div class="adr-row-info">
                    <span class="adr-row-name">{{ $recruiter->name }}</span>
                    <span class="adr-row-company">{{ $recruiter->company_name }} · {{ $recruiter->email }}</span>
                </div>
                <div class="adr-row-actions">
                    <span class="adr-status adr-status-no">✕ Refusé</span>
                    <form action="{{ route('admin.recruiters.approve', $recruiter) }}" method="POST">
                        @csrf
                        <button type="submit" class="adr-mini-btn adr-mini-ok">Approuver finalement</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

</div>

<style>
.adr-page { max-width: 1050px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.adr-header { margin-bottom: 1.75rem; }
.adr-eyebrow { font-size: .72rem; font-weight: 800; letter-spacing: .1em; text-transform: uppercase; color: #6366f1; }
.adr-title { font-size: 1.85rem; font-weight: 900; color: var(--text-primary); letter-spacing: -.04em; margin: .25rem 0 .35rem; }
.adr-subtitle { font-size: .9rem; color: var(--text-muted); margin: 0; max-width: 620px; }

.adr-alert { display: flex; align-items: center; gap: 10px; padding: .9rem 1.2rem; background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.2); border-radius: 12px; margin-bottom: 1.5rem; font-size: .88rem; font-weight: 600; }

.adr-stats { display: flex; gap: 1rem; margin-bottom: 2rem; }
.adr-stat { flex: 1; background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 16px; padding: 1.1rem; display: flex; flex-direction: column; align-items: center; gap: 2px; }
.adr-stat-num { font-size: 1.8rem; font-weight: 900; line-height: 1; }
.adr-stat-label { font-size: .78rem; color: var(--text-muted); font-weight: 600; }

.adr-section { margin-bottom: 2.5rem; }
.adr-section-title { display: flex; align-items: center; gap: 9px; font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin-bottom: 1.1rem; }
.adr-dot { width: 9px; height: 9px; border-radius: 50%; }

.adr-empty { display: flex; flex-direction: column; align-items: center; gap: .75rem; padding: 3rem 1rem; text-align: center; background: rgba(255,255,255,.5); border: 1.5px dashed var(--border-color); border-radius: 16px; }
.adr-empty p { font-size: .88rem; color: var(--text-muted); margin: 0; }

.adr-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.25rem; }
.adr-card { background: rgba(255,255,255,.9); border: 1px solid var(--border-color); border-radius: 18px; overflow: hidden; transition: box-shadow .2s, transform .2s; }
.adr-card:hover { box-shadow: var(--shadow-lg); transform: translateY(-2px); }
.adr-badge-wrap { position: relative; background: #0f172a; }
.adr-badge-img { width: 100%; height: 180px; object-fit: cover; display: block; }
.adr-badge-zoom { position: absolute; bottom: 10px; right: 10px; width: 30px; height: 30px; border-radius: 8px; background: rgba(0,0,0,.6); color: white; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(4px); }
.adr-badge-missing { height: 180px; display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,.4); font-size: .82rem; }

.adr-card-body { padding: 1.1rem 1.25rem 1.25rem; }
.adr-name { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); margin: 0 0 .6rem; }
.adr-meta-row { display: flex; align-items: center; gap: 7px; font-size: .83rem; color: var(--text-muted); margin-bottom: .4rem; }
.adr-meta-row strong { color: var(--text-primary); font-weight: 700; }
.adr-meta-row a { color: var(--text-muted); text-decoration: none; }
.adr-meta-row a:hover { color: var(--success); }
.adr-time { display: block; font-size: .74rem; color: var(--text-muted); opacity: .7; margin: .5rem 0 1rem; }

.adr-actions { display: grid; grid-template-columns: 1fr 1fr; gap: .6rem; }
.adr-btn { display: flex; align-items: center; justify-content: center; gap: 6px; width: 100%; padding: 9px; border-radius: 10px; font-size: .82rem; font-weight: 700; cursor: pointer; border: none; font-family: inherit; transition: opacity .18s, transform .18s; }
.adr-btn:hover { opacity: .88; transform: translateY(-1px); }
.adr-btn-approve { background: linear-gradient(135deg,#6EE7B7,#34d399); color: #0f172a; }
.adr-btn-reject  { background: rgba(239,68,68,.1); color: #dc2626; border: 1px solid rgba(239,68,68,.2); }

.adr-list { display: flex; flex-direction: column; gap: .6rem; }
.adr-row { display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: .85rem 1.1rem; background: rgba(255,255,255,.7); border: 1px solid var(--border-color); border-radius: 12px; }
.adr-row-info { display: flex; flex-direction: column; gap: 2px; min-width: 0; }
.adr-row-name { font-size: .9rem; font-weight: 700; color: var(--text-primary); }
.adr-row-company { font-size: .76rem; color: var(--text-muted); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.adr-row-actions { display: flex; align-items: center; gap: .75rem; flex-shrink: 0; }
.adr-status { font-size: .76rem; font-weight: 700; padding: 3px 10px; border-radius: 999px; }
.adr-status-ok { background: rgba(16,185,129,.12); color: #059669; }
.adr-status-no { background: rgba(239,68,68,.1); color: #dc2626; }
.adr-mini-btn { background: none; border: 1px solid var(--border-color); color: var(--text-muted); font-size: .74rem; font-weight: 700; padding: 4px 11px; border-radius: 8px; cursor: pointer; font-family: inherit; transition: border-color .18s, color .18s; }
.adr-mini-btn:hover { border-color: #dc2626; color: #dc2626; }
.adr-mini-ok:hover { border-color: #059669; color: #059669; }
</style>
@endsection
