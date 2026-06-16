@extends('layouts.app')
@section('title', 'Assistant d\'étude')

@section('content')
<div class="eco-page">
    <div class="eco-head">
        <span class="eco-eyebrow" style="color:#6366f1">Espace Étudiant</span>
        <h1 class="eco-title">Assistant d'<span class="gradient-title">étude</span></h1>
        <p class="eco-subtitle">Posez une question : l'assistant trouve les articles et filières les plus pertinents de la plateforme pour vous aider à réviser.</p>
    </div>

    <div class="ai-chat">
        {{-- Message de bienvenue --}}
        <div class="ai-msg ai-bot">
            <span class="ai-avatar">🤖</span>
            <div class="ai-bubble">
                Bonjour ! Je suis votre assistant d'étude EduBlog. Dites-moi un sujet (ex. « bases de données », « git », « entretien ») et je vous trouve les meilleures ressources.
            </div>
        </div>

        @if($q !== '')
        {{-- Question de l'utilisateur --}}
        <div class="ai-msg ai-user">
            <div class="ai-bubble">{{ $q }}</div>
        </div>

        {{-- Réponse --}}
        <div class="ai-msg ai-bot">
            <span class="ai-avatar">🤖</span>
            <div class="ai-bubble">
                @if($articles->isEmpty() && $majors->isEmpty())
                    Je n'ai pas trouvé de ressource pour « <strong>{{ $q }}</strong> ». Essayez d'autres mots-clés, ou explorez les <a href="{{ route('posts.index') }}">ressources</a>.
                @else
                    Voici ce que j'ai trouvé pour « <strong>{{ $q }}</strong> » :
                    @if($articles->isNotEmpty())
                    <div class="ai-results">
                        <p class="ai-results-label">📚 Articles</p>
                        @foreach($articles as $a)
                        <a href="{{ route('posts.show', $a->slug ?? $a->id) }}" class="ai-result">{{ $a->title }}</a>
                        @endforeach
                    </div>
                    @endif
                    @if($majors->isNotEmpty())
                    <div class="ai-results">
                        <p class="ai-results-label">🎓 Filières liées</p>
                        @foreach($majors as $m)
                        <a href="{{ route('majors.show', $m->slug) }}" class="ai-result">{{ $m->title }}</a>
                        @endforeach
                    </div>
                    @endif
                @endif
            </div>
        </div>
        @endif
    </div>

    {{-- Suggestions --}}
    <div class="ai-suggestions">
        @foreach($suggestions as $s)
        <a href="{{ route('ecosystem.ai', ['q' => $s]) }}" class="ai-chip">{{ $s }}</a>
        @endforeach
    </div>

    {{-- Formulaire --}}
    <form method="GET" action="{{ route('ecosystem.ai') }}" class="ai-form">
        <input type="text" name="q" value="{{ $q }}" placeholder="Posez votre question d'étude..." autofocus>
        <button type="submit">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
        </button>
    </form>
</div>

<style>
.eco-page { max-width: 760px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.eco-head { text-align: center; margin-bottom: 1.75rem; }
.eco-eyebrow { font-size: .74rem; font-weight: 800; letter-spacing: .12em; text-transform: uppercase; }
.eco-title { font-size: 2rem; font-weight: 900; letter-spacing: -.04em; margin: .3rem 0 .4rem; color: var(--text-primary); }
.eco-subtitle { font-size: .92rem; color: var(--text-muted); max-width: 560px; margin: 0 auto; }

.ai-chat { background: rgba(255,255,255,.7); border: 1px solid var(--border-color); border-radius: 18px; padding: 1.25rem; display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1rem; }
.ai-msg { display: flex; gap: 10px; max-width: 85%; }
.ai-bot { align-self: flex-start; }
.ai-user { align-self: flex-end; flex-direction: row-reverse; }
.ai-avatar { width: 34px; height: 34px; border-radius: 50%; background: rgba(99,102,241,.12); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
.ai-bubble { padding: .7rem 1rem; border-radius: 14px; font-size: .9rem; line-height: 1.55; }
.ai-bot .ai-bubble { background: rgba(15,23,42,.05); color: var(--text-primary); border-bottom-left-radius: 4px; }
.ai-user .ai-bubble { background: var(--gradient-primary); color: #0f172a; border-bottom-right-radius: 4px; }
.ai-results { margin-top: .75rem; }
.ai-results-label { font-size: .8rem; font-weight: 700; color: var(--text-muted); margin-bottom: .4rem; }
.ai-result { display: block; padding: .5rem .75rem; background: #fff; border: 1px solid var(--border-color); border-radius: 9px; font-size: .85rem; font-weight: 600; color: var(--text-primary); text-decoration: none; margin-bottom: .35rem; transition: border-color .15s; }
.ai-result:hover { border-color: rgba(110,231,183,.6); }

.ai-suggestions { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1rem; justify-content: center; }
.ai-chip { font-size: .8rem; font-weight: 600; padding: 6px 14px; border-radius: 999px; background: rgba(99,102,241,.08); color: #6366f1; border: 1px solid rgba(99,102,241,.2); text-decoration: none; transition: background .15s; }
.ai-chip:hover { background: rgba(99,102,241,.16); }

.ai-form { display: flex; gap: 8px; }
.ai-form input { flex: 1; border: 1.5px solid var(--border-color); border-radius: 12px; padding: 12px 16px; font-size: .95rem; font-family: inherit; outline: none; }
.ai-form input:focus { border-color: #6366f1; }
.ai-form button { width: 48px; flex-shrink: 0; border: none; border-radius: 12px; background: var(--gradient-primary); color: #0f172a; cursor: pointer; display: flex; align-items: center; justify-content: center; }
</style>
@endsection
