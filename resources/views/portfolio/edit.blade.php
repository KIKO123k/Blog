@extends('layouts.app')
@section('title', 'Mon Portfolio — Modifier')

@section('content')
<div class="pf-edit-page">

    <div class="pfe-header">
        <a href="{{ route('portfolio.show', auth()->user()) }}" class="pfe-back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
            Voir mon portfolio
        </a>
        <h1 class="pfe-title">Mon Portfolio</h1>
        <p class="pfe-subtitle">Complétez vos informations pour que vos camarades puissent vous contacter et découvrir vos réalisations.</p>
    </div>

    @if(session('success'))
    <div class="pfe-alert pfe-alert-success">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif

    <div class="pfe-grid">

        {{-- PROFILE FORM --}}
        <div class="pfe-card">
            <div class="pfe-card-header">
                <div class="pfe-card-icon" style="background:rgba(99,102,241,.12);color:#6366f1">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="5"/><path d="M3 21v-2a9 9 0 0 1 18 0v2"/></svg>
                </div>
                <h2 class="pfe-card-title">Informations personnelles</h2>
            </div>

            <form action="{{ route('portfolio.update') }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="pfe-avatar-row">
                    <div class="pfe-avatar-preview" id="avatarPreview">
                        @if($user->avatar_path)
                            <img src="{{ Storage::url($user->avatar_path) }}" id="avatarImg" alt="Avatar">
                        @else
                            <div class="pfe-avatar-placeholder" id="avatarPlaceholder">{{ strtoupper(substr($user->name,0,2)) }}</div>
                            <img src="" id="avatarImg" style="display:none" alt="Avatar">
                        @endif
                    </div>
                    <div>
                        <label class="pfe-upload-btn">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                            Choisir une photo
                            <input type="file" name="avatar" accept="image/*" class="pfe-file-input" id="avatarInput">
                        </label>
                        <p class="pfe-hint">PNG, JPG jusqu'à 2 Mo</p>
                    </div>
                </div>

                <div class="pfe-form-grid">
                    <div class="pfe-field pfe-full">
                        <label class="pfe-label">Bio / Présentation</label>
                        <textarea name="bio" rows="3" class="pfe-textarea" placeholder="Décrivez-vous en quelques phrases…">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')<span class="pfe-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="pfe-field">
                        <label class="pfe-label">Filière</label>
                        <input type="text" name="filiere" value="{{ old('filiere', $user->filiere) }}" class="pfe-input" placeholder="ex: Génie Informatique">
                    </div>
                    <div class="pfe-field">
                        <label class="pfe-label">Promotion (année)</label>
                        <input type="number" name="promotion" value="{{ old('promotion', $user->promotion) }}" class="pfe-input" placeholder="ex: 2026" min="2000" max="2040">
                    </div>
                    <div class="pfe-field">
                        <label class="pfe-label">LinkedIn</label>
                        <input type="url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}" class="pfe-input" placeholder="https://linkedin.com/in/…">
                    </div>
                    <div class="pfe-field">
                        <label class="pfe-label">GitHub</label>
                        <input type="url" name="github_url" value="{{ old('github_url', $user->github_url) }}" class="pfe-input" placeholder="https://github.com/…">
                    </div>
                    <div class="pfe-field">
                        <label class="pfe-label">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="pfe-input" placeholder="+212 6XX XXX XXX">
                    </div>
                    <div class="pfe-field pfe-full">
                        <label class="pfe-label">Visibilité du téléphone</label>
                        @php $pv = old('phone_privacy', $user->phone_privacy ?? 'friends'); @endphp
                        <div class="pfp-segment">
                            <label class="pfp-card">
                                <input type="radio" name="phone_privacy" value="public" {{ $pv === 'public' ? 'checked' : '' }}>
                                <span class="pfp-inner">
                                    <span class="pfp-icon pfp-icon-public">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                    </span>
                                    <span class="pfp-text">
                                        <span class="pfp-name">Public</span>
                                        <span class="pfp-desc">Tout le monde</span>
                                    </span>
                                    <span class="pfp-check">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                </span>
                            </label>

                            <label class="pfp-card">
                                <input type="radio" name="phone_privacy" value="friends" {{ $pv === 'friends' ? 'checked' : '' }}>
                                <span class="pfp-inner">
                                    <span class="pfp-icon pfp-icon-friends">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    </span>
                                    <span class="pfp-text">
                                        <span class="pfp-name">Amis</span>
                                        <span class="pfp-desc">Amis acceptés</span>
                                    </span>
                                    <span class="pfp-check">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                </span>
                            </label>

                            <label class="pfp-card">
                                <input type="radio" name="phone_privacy" value="private" {{ $pv === 'private' ? 'checked' : '' }}>
                                <span class="pfp-inner">
                                    <span class="pfp-icon pfp-icon-private">
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    </span>
                                    <span class="pfp-text">
                                        <span class="pfp-name">Privé</span>
                                        <span class="pfp-desc">Moi seul</span>
                                    </span>
                                    <span class="pfp-check">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    </span>
                                </span>
                            </label>
                        </div>
                        <p class="pfe-hint">Contrôlez qui peut voir votre numéro de téléphone.</p>
                    </div>
                    <div class="pfe-field pfe-full">
                        <label class="pfe-label">Curriculum Vitae (PDF)</label>
                        <label class="pfe-upload-btn pfe-upload-pdf">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            @if($user->cv_path) Remplacer le CV @else Uploader mon CV @endif
                            <input type="file" name="cv" accept="application/pdf" class="pfe-file-input" id="cvInput">
                        </label>
                        @if($user->cv_path)
                        <a href="{{ route('files.cv', $user) }}" target="_blank" class="pfe-cv-link">Voir le CV actuel →</a>
                        @endif
                        <p class="pfe-hint">PDF jusqu'à 5 Mo</p>
                        @error('cv')<span class="pfe-error">{{ $message }}</span>@enderror
                    </div>
                </div>

                <button type="submit" class="pfe-submit">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Enregistrer les informations
                </button>
            </form>
        </div>

        <div class="pfe-right-col">

            {{-- ADD PROJECT --}}
            <div class="pfe-card">
                <div class="pfe-card-header">
                    <div class="pfe-card-icon" style="background:rgba(99,102,241,.12);color:#6366f1">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                    </div>
                    <h2 class="pfe-card-title">Ajouter un projet</h2>
                </div>

                <form action="{{ route('portfolio.projects.store') }}" method="POST">
                    @csrf
                    <div class="pfe-form-grid">
                        <div class="pfe-field pfe-full">
                            <label class="pfe-label">Titre *</label>
                            <input type="text" name="title" class="pfe-input" placeholder="Nom du projet" required>
                        </div>
                        <div class="pfe-field pfe-full">
                            <label class="pfe-label">Description</label>
                            <textarea name="description" rows="2" class="pfe-textarea" placeholder="Courte description du projet…"></textarea>
                        </div>
                        <div class="pfe-field pfe-full">
                            <label class="pfe-label">Technologies (séparées par virgule)</label>
                            <input type="text" name="technologies" class="pfe-input" placeholder="Python, TensorFlow, Flask, …">
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Lien GitHub</label>
                            <input type="url" name="github_url" class="pfe-input" placeholder="https://github.com/…">
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Lien Démo</label>
                            <input type="url" name="demo_url" class="pfe-input" placeholder="https://…">
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Année</label>
                            <input type="number" name="year" class="pfe-input" placeholder="{{ date('Y') }}" min="2000" max="2040">
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Type *</label>
                            <select name="type" class="pfe-input" required>
                                <option value="academique">Académique</option>
                                <option value="personnel">Personnel</option>
                                <option value="stage">Stage</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="pfe-submit pfe-submit-sm">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Ajouter le projet
                    </button>
                </form>

                @if($user->projects->isNotEmpty())
                <div class="pfe-items-list">
                    <p class="pfe-items-label">Projets existants</p>
                    @foreach($user->projects as $project)
                    <div class="pfe-item-row">
                        <span class="pfe-item-name">{{ $project->title }}</span>
                        <div style="display:flex;align-items:center;gap:.5rem">
                            <span class="pfe-item-meta">{{ $project->year }}</span>
                            <form action="{{ route('portfolio.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Supprimer ce projet ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="pfe-del-btn" title="Supprimer">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- ADD INTERNSHIP --}}
            <div class="pfe-card">
                <div class="pfe-card-header">
                    <div class="pfe-card-icon" style="background:rgba(245,158,11,.12);color:#f59e0b">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                    </div>
                    <h2 class="pfe-card-title">Ajouter un stage</h2>
                </div>

                <form action="{{ route('portfolio.internships.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="pfe-form-grid">
                        <div class="pfe-field">
                            <label class="pfe-label">Entreprise *</label>
                            <input type="text" name="company" class="pfe-input" placeholder="Nom de l'entreprise" required>
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Poste / Mission *</label>
                            <input type="text" name="position" class="pfe-input" placeholder="Développeur web, Automaticien, …" required>
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Période *</label>
                            <input type="text" name="period" class="pfe-input" placeholder="Juin–Août 2025" required>
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Année</label>
                            <input type="number" name="year" class="pfe-input" placeholder="{{ date('Y') }}" min="2000" max="2040">
                        </div>
                        <div class="pfe-field pfe-full">
                            <label class="pfe-label">Description</label>
                            <textarea name="description" rows="2" class="pfe-textarea" placeholder="Missions réalisées, technologies utilisées…"></textarea>
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Type *</label>
                            <select name="type" class="pfe-input" required>
                                <option value="observation">Stage d'observation</option>
                                <option value="execution">Stage d'exécution</option>
                                <option value="pfe">PFE</option>
                            </select>
                        </div>
                        <div class="pfe-field">
                            <label class="pfe-label">Rapport de stage (PDF)</label>
                            <label class="pfe-upload-btn pfe-upload-sm">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                Choisir PDF
                                <input type="file" name="report" accept="application/pdf" class="pfe-file-input">
                            </label>
                            <p class="pfe-hint">PDF max 10 Mo</p>
                        </div>
                    </div>
                    <button type="submit" class="pfe-submit pfe-submit-sm pfe-submit-amber">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Ajouter le stage
                    </button>
                </form>

                @if($user->internships->isNotEmpty())
                <div class="pfe-items-list">
                    <p class="pfe-items-label">Stages existants</p>
                    @foreach($user->internships as $internship)
                    <div class="pfe-item-row">
                        <div>
                            <span class="pfe-item-name">{{ $internship->position }}</span>
                            <span class="pfe-item-meta"> · {{ $internship->company }}</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:.5rem">
                            <span class="pfe-item-meta">{{ $internship->period }}</span>
                            <form action="{{ route('portfolio.internships.destroy', $internship) }}" method="POST" onsubmit="return confirm('Supprimer ce stage ?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="pfe-del-btn" title="Supprimer">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
document.getElementById('avatarInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(ev) {
        const img = document.getElementById('avatarImg');
        const placeholder = document.getElementById('avatarPlaceholder');
        img.src = ev.target.result;
        img.style.display = 'block';
        if (placeholder) placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>

<style>
.pf-edit-page { max-width: 1050px; margin: 0 auto; padding: 2rem 1.5rem 4rem; }
.pfe-header { margin-bottom: 2rem; }
.pfe-back { display: inline-flex; align-items: center; gap: 6px; font-size: .82rem; font-weight: 700; color: var(--text-muted); text-decoration: none; margin-bottom: .75rem; }
.pfe-back:hover { color: var(--text-primary); }
.pfe-title { font-size: 2rem; font-weight: 900; color: var(--text-primary); letter-spacing: -.04em; margin: 0 0 .35rem; }
.pfe-subtitle { font-size: .9rem; color: var(--text-muted); margin: 0; }

.pfe-alert { display: flex; align-items: center; gap: 10px; padding: 1rem 1.25rem; border-radius: 14px; margin-bottom: 1.5rem; font-size: .88rem; font-weight: 600; }
.pfe-alert-success { background: rgba(16,185,129,.1); color: #059669; border: 1px solid rgba(16,185,129,.2); }

.pfe-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 1.5rem; align-items: start; }
@media(max-width: 768px) { .pfe-grid { grid-template-columns: 1fr; } }
.pfe-right-col { display: flex; flex-direction: column; gap: 1.5rem; }

.pfe-card { background: rgba(255,255,255,.85); border: 1px solid var(--border-color); border-radius: 20px; padding: 1.5rem; backdrop-filter: blur(8px); }
.pfe-card-header { display: flex; align-items: center; gap: .75rem; margin-bottom: 1.5rem; }
.pfe-card-icon { width: 38px; height: 38px; border-radius: 11px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
.pfe-card-title { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); }

.pfe-avatar-row { display: flex; align-items: center; gap: 1.25rem; margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 1px solid var(--border-color); }
.pfe-avatar-preview { width: 72px; height: 72px; border-radius: 50%; overflow: hidden; flex-shrink: 0; background: var(--bg-tertiary); }
.pfe-avatar-preview img { width: 100%; height: 100%; object-fit: cover; }
.pfe-avatar-placeholder { width: 72px; height: 72px; border-radius: 50%; background: linear-gradient(135deg,#6EE7B7,#34d399); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 800; color: #0f172a; }

.pfe-form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: .9rem; margin-bottom: 1.25rem; }
.pfe-field { display: flex; flex-direction: column; gap: 5px; }
.pfe-full { grid-column: 1 / -1; }
.pfe-label { font-size: .8rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: .04em; }
.pfe-input { padding: 9px 13px; background: var(--bg-tertiary); border: 1.5px solid var(--border-color); border-radius: 10px; font-size: .88rem; color: var(--text-primary); outline: none; transition: border-color .18s; font-family: inherit; width: 100%; box-sizing: border-box; }
.pfe-input:focus { border-color: #6EE7B7; }
.pfe-textarea { padding: 9px 13px; background: var(--bg-tertiary); border: 1.5px solid var(--border-color); border-radius: 10px; font-size: .88rem; color: var(--text-primary); outline: none; resize: vertical; font-family: inherit; width: 100%; box-sizing: border-box; transition: border-color .18s; }
.pfe-textarea:focus { border-color: #6EE7B7; }
.pfe-error { font-size: .78rem; color: #dc2626; font-weight: 600; }
.pfe-hint { font-size: .75rem; color: var(--text-muted); margin: 2px 0 0; }
.pfe-cv-link { font-size: .8rem; color: var(--success); font-weight: 700; text-decoration: none; margin-top: 4px; display: inline-block; }

.pfe-upload-btn { display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; background: var(--bg-tertiary); border: 1.5px dashed var(--border-color); border-radius: 10px; font-size: .82rem; font-weight: 700; color: var(--text-primary); cursor: pointer; transition: border-color .18s, background .18s; }
.pfe-upload-btn:hover { border-color: #6EE7B7; background: rgba(110,231,183,.06); }
.pfe-upload-pdf { width: 100%; box-sizing: border-box; justify-content: center; }
.pfe-upload-sm { padding: 6px 12px; font-size: .78rem; }
.pfe-file-input { display: none; }

.pfe-submit { display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; padding: 12px; background: var(--gradient-primary); color: #0f172a; border: none; border-radius: 12px; font-weight: 800; font-size: .9rem; cursor: pointer; transition: opacity .2s; font-family: inherit; }
.pfe-submit:hover { opacity: .88; }
.pfe-submit-sm { padding: 9px; font-size: .82rem; margin-top: .25rem; }
.pfe-submit-amber { background: linear-gradient(135deg, #fbbf24, #f59e0b); }

.pfe-items-list { margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid var(--border-color); display: flex; flex-direction: column; gap: .5rem; }
.pfe-items-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .06em; color: var(--text-muted); margin: 0 0 .5rem; }
.pfe-item-row { display: flex; align-items: center; justify-content: space-between; padding: .6rem .9rem; background: var(--bg-tertiary); border-radius: 10px; }
.pfe-item-name { font-size: .85rem; font-weight: 700; color: var(--text-primary); }
.pfe-item-meta { font-size: .78rem; color: var(--text-muted); }
.pfe-del-btn { background: none; border: none; cursor: pointer; color: #dc2626; opacity: .6; padding: 4px; border-radius: 6px; display: flex; align-items: center; transition: opacity .18s, background .18s; }
.pfe-del-btn:hover { opacity: 1; background: rgba(239,68,68,.1); }

/* ===== Modern phone-privacy segmented picker ===== */
.pfp-segment { display: grid; grid-template-columns: repeat(3, 1fr); gap: .6rem; margin-top: 2px; }
@media(max-width: 480px) { .pfp-segment { grid-template-columns: 1fr; } }

.pfp-card { position: relative; cursor: pointer; display: block; }
.pfp-card input { position: absolute; opacity: 0; width: 0; height: 0; pointer-events: none; }

.pfp-inner {
    display: flex; flex-direction: column; align-items: flex-start; gap: .55rem;
    padding: .9rem .85rem; border-radius: 14px;
    background: var(--bg-tertiary);
    border: 1.5px solid var(--border-color);
    transition: border-color .2s, background .2s, box-shadow .2s, transform .15s;
    height: 100%; box-sizing: border-box;
}
.pfp-card:hover .pfp-inner { border-color: rgba(110,231,183,.45); transform: translateY(-2px); }

.pfp-icon {
    width: 38px; height: 38px; border-radius: 11px;
    display: flex; align-items: center; justify-content: center;
    transition: transform .2s;
}
.pfp-icon-public  { background: rgba(59,130,246,.12);  color: #3b82f6; }
.pfp-icon-friends { background: rgba(99,102,241,.12);  color: #6366f1; }
.pfp-icon-private { background: rgba(100,116,139,.14); color: #475569; }
.pfp-card:hover .pfp-icon { transform: scale(1.08); }

.pfp-text { display: flex; flex-direction: column; gap: 1px; }
.pfp-name { font-size: .9rem; font-weight: 800; color: var(--text-primary); letter-spacing: -.01em; }
.pfp-desc { font-size: .72rem; color: var(--text-muted); }

.pfp-check {
    position: absolute; top: .65rem; right: .65rem;
    width: 20px; height: 20px; border-radius: 50%;
    background: var(--gradient-primary); color: #0f172a;
    display: flex; align-items: center; justify-content: center;
    opacity: 0; transform: scale(.4); transition: opacity .2s, transform .2s;
}

/* Selected state */
.pfp-card input:checked + .pfp-inner {
    border-color: #34d399;
    background: linear-gradient(135deg, rgba(110,231,183,.14), rgba(52,211,153,.06));
    box-shadow: 0 0 0 3px rgba(110,231,183,.16), var(--shadow-sm);
}
.pfp-card input:checked + .pfp-inner .pfp-check { opacity: 1; transform: scale(1); }
.pfp-card input:checked + .pfp-inner .pfp-name { color: #047857; }

/* Keyboard focus ring for accessibility */
.pfp-card input:focus-visible + .pfp-inner { border-color: #34d399; box-shadow: 0 0 0 3px rgba(110,231,183,.3); }
</style>
@endsection
