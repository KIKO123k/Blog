@extends('layouts.app')
@section('title', 'Notifications')

@php
    $icons = [
        'friend'    => '<path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'message'   => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'recruiter' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/>',
        'comment'   => '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8z"/>',
        'bell'      => '<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>',
    ];
@endphp

@section('content')
<div class="ntf-page">
    <div class="ntf-head">
        <h1>Notifications</h1>
    </div>

    @if($notifications->isEmpty())
    <div class="ntf-empty">
        <svg width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" opacity=".25"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
        <p>Aucune notification pour le moment.</p>
    </div>
    @else
    <div class="ntf-list">
        @foreach($notifications as $n)
        <a href="{{ route('notifications.open', $n) }}" class="ntf-item {{ $n->read_at ? '' : 'unread' }}">
            <span class="ntf-icon" style="background: {{ $n->color }}1a; color: {{ $n->color }};">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">{!! $icons[$n->icon] ?? $icons['bell'] !!}</svg>
            </span>
            <span class="ntf-body">
                <span class="ntf-title">{{ $n->title }}</span>
                @if($n->body)<span class="ntf-text">{{ $n->body }}</span>@endif
                <span class="ntf-time">{{ $n->created_at->diffForHumans() }}</span>
            </span>
            @unless($n->read_at)<span class="ntf-dot"></span>@endunless
        </a>
        @endforeach
    </div>
    <div class="ntf-pagination">{{ $notifications->links() }}</div>
    @endif
</div>

<style>
.ntf-page { max-width: 680px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.ntf-head { margin-bottom: 1.5rem; }
.ntf-head h1 { font-size: 1.8rem; font-weight: 900; letter-spacing: -.03em; color: var(--text-primary); }
.ntf-empty { text-align: center; padding: 4rem 1rem; color: var(--text-muted); display: flex; flex-direction: column; align-items: center; gap: 1rem; }
.ntf-list { display: flex; flex-direction: column; gap: .5rem; }
.ntf-item { display: flex; align-items: flex-start; gap: 12px; padding: 1rem 1.1rem; background: rgba(255,255,255,.8); border: 1px solid var(--border-color); border-radius: 14px; text-decoration: none; transition: transform .15s, border-color .15s; position: relative; }
.ntf-item:hover { transform: translateX(3px); border-color: rgba(110,231,183,.5); }
.ntf-item.unread { background: rgba(110,231,183,.07); border-color: rgba(110,231,183,.3); }
.ntf-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.ntf-body { display: flex; flex-direction: column; gap: 2px; flex: 1; min-width: 0; }
.ntf-title { font-size: .92rem; font-weight: 700; color: var(--text-primary); }
.ntf-text { font-size: .83rem; color: var(--text-muted); }
.ntf-time { font-size: .72rem; color: var(--text-muted); opacity: .8; margin-top: 2px; }
.ntf-dot { width: 9px; height: 9px; border-radius: 50%; background: #34d399; flex-shrink: 0; margin-top: 6px; }
.ntf-pagination { margin-top: 1.5rem; display: flex; justify-content: center; }
</style>
@endsection
