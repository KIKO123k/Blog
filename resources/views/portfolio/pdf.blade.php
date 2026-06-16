<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: DejaVu Sans, sans-serif; color: #1e293b; font-size: 11px; line-height: 1.5; }
    .wrap { padding: 32px 36px; }

    .header { border-bottom: 3px solid #10b981; padding-bottom: 14px; margin-bottom: 18px; }
    .name { font-size: 26px; font-weight: bold; color: #0f172a; }
    .filiere { font-size: 13px; color: #059669; font-weight: bold; margin-top: 2px; }
    .contact { margin-top: 8px; font-size: 10.5px; color: #475569; }
    .contact span { margin-right: 14px; }

    .section { margin-bottom: 16px; }
    .section-title { font-size: 13px; font-weight: bold; color: #0f172a; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #e2e8f0; padding-bottom: 4px; margin-bottom: 9px; }

    .bio { color: #475569; font-size: 11px; }

    .item { margin-bottom: 11px; }
    .item-title { font-size: 12px; font-weight: bold; color: #0f172a; }
    .item-sub { font-size: 10.5px; color: #6366f1; font-weight: bold; }
    .item-meta { font-size: 10px; color: #94a3b8; }
    .item-desc { font-size: 10.5px; color: #475569; margin-top: 2px; }
    .tags { margin-top: 3px; }
    .tag { display: inline-block; background: #f1f5f9; color: #475569; font-size: 9px; padding: 2px 7px; border-radius: 4px; margin-right: 4px; }

    .empty { color: #94a3b8; font-style: italic; font-size: 10.5px; }
    .footer { margin-top: 20px; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 9px; color: #94a3b8; text-align: center; }
</style>
</head>
<body>
<div class="wrap">

    <div class="header">
        <div class="name">{{ $user->name }}</div>
        @if($user->filiere)<div class="filiere">{{ $user->filiere }}@if($user->promotion) · Promotion {{ $user->promotion }}@endif — ENSA Kénitra</div>@endif
        <div class="contact">
            <span>✉ {{ $user->email }}</span>
            @if($isOwner && $user->phone)<span>☎ {{ $user->phone }}</span>@endif
            @if($user->linkedin_url)<span>in: {{ $user->linkedin_url }}</span>@endif
            @if($user->github_url)<span>git: {{ $user->github_url }}</span>@endif
        </div>
    </div>

    @if($user->bio)
    <div class="section">
        <div class="section-title">Profil</div>
        <div class="bio">{{ $user->bio }}</div>
    </div>
    @endif

    <div class="section">
        <div class="section-title">Projets</div>
        @forelse($user->projects as $p)
        <div class="item">
            <div class="item-title">{{ $p->title }} @if($p->year)<span class="item-meta">— {{ $p->year }}</span>@endif</div>
            @if($p->description)<div class="item-desc">{{ $p->description }}</div>@endif
            @if($p->technologies)
            <div class="tags">@foreach($p->technologies as $t)<span class="tag">{{ $t }}</span>@endforeach</div>
            @endif
        </div>
        @empty
        <div class="empty">Aucun projet renseigné.</div>
        @endforelse
    </div>

    <div class="section">
        <div class="section-title">Expériences / Stages</div>
        @forelse($user->internships as $i)
        <div class="item">
            <div class="item-title">{{ $i->position }}</div>
            <div class="item-sub">{{ $i->company }} <span class="item-meta">· {{ $i->period }}</span></div>
            @if($i->description)<div class="item-desc">{{ $i->description }}</div>@endif
        </div>
        @empty
        <div class="empty">Aucun stage renseigné.</div>
        @endforelse
    </div>

    <div class="footer">CV généré depuis EduBlog — ENSA Kénitra · {{ now()->format('d/m/Y') }}</div>
</div>
</body>
</html>
