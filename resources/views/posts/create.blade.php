@extends('layouts.app')

@section('title', 'Publier un article')

@section('content')

    <!-- Bouton de retour -->
    <div class="back-link-wrapper">
        <a href="{{ route('posts.index') }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour aux articles
        </a>
    </div>

    <!-- Formulaire d'ajout d'article -->
    <div class="form-container glass">
        
        <div class="form-title-group">
            <h1>Rédiger un <span class="gradient-title">Nouvel Article</span></h1>
            <p>Remplissez le formulaire ci-dessous pour publier votre article sur le blog.</p>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Champ : Titre -->
            <div class="form-group">
                <label for="title" class="form-label">Titre de l'article</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Entrez un titre percutant..." required>
                @error('title')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>



            <!-- Champ : Contenu -->
            <div class="form-group">
                <label for="content" class="form-label">Contenu de l'article</label>
                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" placeholder="Rédigez le corps de votre publication ici..." required>{{ old('content') }}</textarea>
                @error('content')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Image (Drag & Drop Mockup Style) -->
            <div class="form-group">
                <label class="form-label">Image d'illustration (optionnelle)</label>
                <div class="file-upload-wrapper">
                    <svg class="file-upload-icon" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <div class="file-upload-text" id="file-upload-text">Glissez-déposez une image ou cliquez pour parcourir</div>
                    <div class="file-upload-hint">Formats autorisés : JPEG, PNG, JPG, GIF (Max. 2 Mo)</div>
                    <input type="file" name="image" id="image" class="file-upload-input" onchange="updateFileName(this)">
                </div>
                @error('image')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Publier l'article
                </button>
            </div>
        </form>

    </div>

    <!-- Script JS léger pour afficher dynamiquement le nom de fichier sélectionné -->
    <script>
        function updateFileName(input) {
            const textElement = document.getElementById('file-upload-text');
            if (input.files && input.files.length > 0) {
                textElement.innerText = "Fichier sélectionné : " + input.files[0].name;
                textElement.style.color = "var(--primary)";
                textElement.style.fontWeight = "600";
            } else {
                textElement.innerText = "Glissez-déposez une image ou cliquez pour parcourir";
                textElement.style.color = "var(--text-secondary)";
                textElement.style.fontWeight = "normal";
            }
        }
    </script>

@endsection
