@extends('layouts.app')

@section('title', 'Modifier l\'article')

@section('content')

    <!-- Bouton de retour -->
    <div class="back-link-wrapper">
        <a href="{{ route('posts.show', $post->id) }}" class="back-link">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"></line>
                <polyline points="12 19 5 12 12 5"></polyline>
            </svg>
            Retour à l'article
        </a>
    </div>

    <!-- Formulaire d'édition de l'article -->
    <div class="form-container glass">
        
        <div class="form-title-group">
            <h1>Modifier l'<span class="gradient-title">Article</span></h1>
            <p>Apportez vos modifications aux champs ci-dessous puis validez la mise à jour.</p>
        </div>

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Champ : Titre -->
            <div class="form-group">
                <label for="title" class="form-label">Titre de l'article</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $post->title) }}" placeholder="Entrez un titre..." required>
                @error('title')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>



            <!-- Champ : Contenu -->
            <div class="form-group">
                <label for="content" class="form-label">Contenu de l'article</label>
                <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror" placeholder="Rédigez le contenu..." required>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Champ : Image (avec aperçu de l'image existante) -->
            <div class="form-group">
                <label class="form-label">Image d'illustration</label>
                
                @if($post->image)
                    <div class="current-image-preview">
                        <img src="{{ str_starts_with($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}" alt="Aperçu actuel">
                        <div>
                            <span class="form-label" style="margin-bottom: 2px;">Image actuelle</span>
                            <span style="font-size: 12px; color: var(--text-muted);">Cette image sera conservée si vous n'en téléversez pas une nouvelle.</span>
                        </div>
                    </div>
                @endif
                
                <div class="file-upload-wrapper" style="margin-top: 15px;">
                    <svg class="file-upload-icon" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                        <polyline points="21 15 16 10 5 21"></polyline>
                    </svg>
                    <div class="file-upload-text" id="file-upload-text">Glissez-déposez une nouvelle image ou cliquez pour parcourir</div>
                    <div class="file-upload-hint">Formats autorisés : JPEG, PNG, JPG, GIF (Max. 2 Mo)</div>
                    <input type="file" name="image" id="image" class="file-upload-input" onchange="updateFileName(this)">
                </div>
                @error('image')
                    <span class="error-text">{{ $message }}</span>
                @enderror
            </div>

            <!-- Boutons d'action -->
            <div class="form-actions">
                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                        <polyline points="17 21 17 13 7 13 7 21"></polyline>
                        <polyline points="7 3 7 8 15 8"></polyline>
                    </svg>
                    Enregistrer les modifications
                </button>
            </div>
        </form>

    </div>

    <!-- Script JS léger pour afficher dynamiquement le nom de fichier sélectionné -->
    <script>
        function updateFileName(input) {
            const textElement = document.getElementById('file-upload-text');
            if (input.files && input.files.length > 0) {
                textElement.innerText = "Nouveau fichier : " + input.files[0].name;
                textElement.style.color = "var(--primary)";
                textElement.style.fontWeight = "600";
            } else {
                textElement.innerText = "Glissez-déposez une nouvelle image ou cliquez pour parcourir";
                textElement.style.color = "var(--text-secondary)";
                textElement.style.fontWeight = "normal";
            }
        }
    </script>

@endsection
