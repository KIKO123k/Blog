@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

    <div class="form-container glass reg-card">

        <div class="form-title-group">
            <h1>Créer un <span class="gradient-title">compte</span></h1>
            <p>Rejoignez la plateforme en tant qu'étudiant ou recruteur.</p>
        </div>

        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data" id="registerForm">
            @csrf

            @php $type = old('account_type', 'student'); @endphp

            {{-- ===== Account type selector ===== --}}
            <div class="form-group">
                <label class="form-label">Je suis</label>
                <div class="acct-segment">
                    <label class="acct-card">
                        <input type="radio" name="account_type" value="student" {{ $type === 'student' ? 'checked' : '' }} onchange="toggleRecruiterFields()">
                        <span class="acct-inner">
                            <span class="acct-icon acct-icon-student">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                            </span>
                            <span class="acct-text">
                                <span class="acct-name">Étudiant</span>
                                <span class="acct-desc">Adresse @uit.ac.ma requise</span>
                            </span>
                            <span class="acct-check"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        </span>
                    </label>

                    <label class="acct-card">
                        <input type="radio" name="account_type" value="recruiter" {{ $type === 'recruiter' ? 'checked' : '' }} onchange="toggleRecruiterFields()">
                        <span class="acct-inner">
                            <span class="acct-icon acct-icon-recruiter">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                            </span>
                            <span class="acct-text">
                                <span class="acct-name">Recruteur</span>
                                <span class="acct-desc">Vérification requise</span>
                            </span>
                            <span class="acct-check"><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
                        </span>
                    </label>
                </div>
                @error('account_type')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="reg-divider"></div>

            {{-- Nom --}}
            <div class="form-group">
                <label for="name" class="form-label" id="nameLabel">Nom complet</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Ex. Jean Dupont..." required autofocus>
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Adresse email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="vous@uit.ac.ma" required>
                <span class="field-hint" id="emailHint">Les étudiants doivent utiliser leur adresse institutionnelle <strong>@uit.ac.ma</strong>.</span>
                @error('email')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            {{-- ===== Recruiter-only fields ===== --}}
            <div id="recruiterFields" class="recruiter-block" style="{{ $type === 'recruiter' ? '' : 'display:none' }}">
                <div class="recruiter-block-head">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12l2 2 4-4"/><path d="M21 12c-1 0-3-1-3-3s2-3 3-3-1-3-3-3-3 2-3 3-1-3-3-3-3 2-3 3-1 3-3 3 2 3 3 3-1 3 0 3 3-1 3-3 3 2 3 3 3-1 3-3 3z"/></svg>
                    Vérification recruteur
                </div>
                <p class="recruiter-block-note">Pour protéger les CV des étudiants, votre statut de recruteur est vérifié par un administrateur avant l'accès.</p>

                <div class="form-group">
                    <label for="company_name" class="form-label">Nom de l'entreprise</label>
                    <input type="text" name="company_name" id="company_name" class="form-control @error('company_name') is-invalid @enderror" value="{{ old('company_name') }}" placeholder="Ex. OCP Group, Capgemini...">
                    @error('company_name')<span class="error-text">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Badge / Carte professionnelle</label>
                    <label class="badge-upload" id="badgeUpload">
                        <input type="file" name="badge" id="badge" accept="image/*" class="badge-input" onchange="previewBadge(event)">
                        <div class="badge-upload-content" id="badgeContent">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            <span class="badge-upload-title">Capturer / téléverser votre badge</span>
                            <span class="badge-upload-sub">JPG, PNG ou WEBP · max 4 Mo</span>
                        </div>
                        <img id="badgePreview" class="badge-preview" style="display:none" alt="Aperçu du badge">
                    </label>
                    @error('badge')<span class="error-text">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="reg-divider"></div>

            {{-- Mot de passe (2 colonnes) --}}
            <div class="reg-grid-2">
                <div class="form-group">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min. 8 caractères..." required>
                    @error('password')<span class="error-text">{{ $message }}</span>@enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Ressaisissez...">
                </div>
            </div>

            <div style="margin-top: 28px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="8.5" cy="7" r="4"></circle>
                        <line x1="20" y1="8" x2="20" y2="14"></line>
                        <line x1="23" y1="11" x2="17" y2="11"></line>
                    </svg>
                    S'inscrire
                </button>
            </div>

            <div class="auth-footer-text">
                Déjà inscrit ? <a href="{{ route('login') }}">Connectez-vous ici</a>
            </div>
        </form>
    </div>

    <script>
        function toggleRecruiterFields() {
            const isRecruiter = document.querySelector('input[name="account_type"]:checked').value === 'recruiter';
            document.getElementById('recruiterFields').style.display = isRecruiter ? 'block' : 'none';
            document.getElementById('company_name').required = isRecruiter;
            document.getElementById('badge').required = isRecruiter;
            document.getElementById('nameLabel').textContent = isRecruiter ? 'Nom du recruteur' : 'Nom complet';
            document.getElementById('email').placeholder = isRecruiter ? 'vous@entreprise.com' : 'vous@uit.ac.ma';
            document.getElementById('emailHint').innerHTML = isRecruiter
                ? "Utilisez votre <strong>email professionnel</strong> (tout domaine accepté)."
                : "Les étudiants doivent utiliser leur adresse institutionnelle <strong>@uit.ac.ma</strong>.";
        }

        function previewBadge(e) {
            const file = e.target.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = (ev) => {
                const img = document.getElementById('badgePreview');
                img.src = ev.target.result;
                img.style.display = 'block';
                document.getElementById('badgeContent').style.display = 'none';
                document.getElementById('badgeUpload').classList.add('has-image');
            };
            reader.readAsDataURL(file);
        }

        // Ensure correct state on load (e.g. after validation error)
        toggleRecruiterFields();
    </script>

    <style>
        /* Register card layout — resolves the .form-container(700)/.auth-container(480) width clash */
        .reg-card { max-width: 560px; margin: 40px auto; padding: 38px 40px; }
        @media (max-width: 600px) { .reg-card { padding: 26px 20px; margin: 20px auto; } }

        /* Tighter, consistent vertical rhythm inside the register form */
        .reg-card .form-group { margin-bottom: 18px; }

        /* Subtle section separator */
        .reg-divider { height: 1px; background: linear-gradient(to right, transparent, var(--border-color), transparent); margin: 22px 0; border: 0; }

        /* Two-column row (password + confirmation) */
        .reg-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        @media (max-width: 460px) { .reg-grid-2 { grid-template-columns: 1fr; gap: 0; } }

        .field-hint { display: block; font-size: .76rem; color: var(--text-muted); margin-top: 5px; }

        /* Account type segmented picker */
        .acct-segment { display: grid; grid-template-columns: 1fr 1fr; gap: .7rem; }
        .acct-card { position: relative; cursor: pointer; display: flex; }
        .acct-card input { position: absolute; opacity: 0; width: 0; height: 0; }
        .acct-inner {
            display: flex; align-items: center; gap: .7rem;
            width: 100%; min-height: 76px;
            padding: .85rem .9rem; border-radius: 14px;
            background: var(--bg-tertiary, rgba(15,23,42,.03));
            border: 1.5px solid var(--border-color);
            transition: border-color .2s, background .2s, box-shadow .2s, transform .15s;
        }
        .acct-card:hover .acct-inner { border-color: rgba(110,231,183,.45); transform: translateY(-2px); }
        .acct-icon { width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .acct-icon-student   { background: rgba(110,231,183,.15); color: #059669; }
        .acct-icon-recruiter { background: rgba(99,102,241,.12);  color: #6366f1; }
        .acct-text { display: flex; flex-direction: column; gap: 1px; min-width: 0; }
        .acct-name { font-size: .92rem; font-weight: 800; color: var(--text-primary); }
        .acct-desc { font-size: .72rem; color: var(--text-muted); line-height: 1.3; }
        .acct-check {
            position: absolute; top: .6rem; right: .6rem; width: 20px; height: 20px; border-radius: 50%;
            background: var(--gradient-primary, linear-gradient(135deg,#6EE7B7,#34d399)); color: #0f172a;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; transform: scale(.4); transition: opacity .2s, transform .2s;
        }
        .acct-card input:checked + .acct-inner {
            border-color: #34d399;
            background: linear-gradient(135deg, rgba(110,231,183,.14), rgba(52,211,153,.05));
            box-shadow: 0 0 0 3px rgba(110,231,183,.16);
        }
        .acct-card input:checked + .acct-inner .acct-check { opacity: 1; transform: scale(1); }

        /* Recruiter block */
        .recruiter-block {
            margin: 0 0 1.25rem; padding: 1.1rem 1.15rem 1.25rem;
            border: 1.5px solid rgba(99,102,241,.25); border-radius: 16px;
            background: linear-gradient(135deg, rgba(99,102,241,.05), rgba(99,102,241,.01));
        }
        .recruiter-block-head { display: flex; align-items: center; gap: 7px; font-size: .82rem; font-weight: 800; color: #6366f1; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 6px; }
        .recruiter-block-note { font-size: .78rem; color: var(--text-muted); line-height: 1.5; margin: 0 0 1rem; }

        /* Badge upload */
        .badge-upload {
            display: block; position: relative; cursor: pointer;
            border: 2px dashed rgba(99,102,241,.35); border-radius: 14px;
            background: rgba(99,102,241,.04); overflow: hidden;
            transition: border-color .2s, background .2s;
        }
        .badge-upload:hover { border-color: #6366f1; background: rgba(99,102,241,.08); }
        .badge-upload.has-image { border-style: solid; padding: 0; }
        .badge-input { position: absolute; opacity: 0; width: 0; height: 0; }
        .badge-upload-content { display: flex; flex-direction: column; align-items: center; gap: 6px; padding: 1.6rem 1rem; text-align: center; color: #6366f1; }
        .badge-upload-title { font-size: .85rem; font-weight: 700; color: var(--text-primary); }
        .badge-upload-sub { font-size: .72rem; color: var(--text-muted); }
        .badge-preview { width: 100%; max-height: 220px; object-fit: contain; display: block; background: #0f172a; }
    </style>

@endsection
