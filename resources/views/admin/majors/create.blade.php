@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="{{ route('admin.majors.index') }}" class="btn btn-outline-secondary btn-sm">&larr; Retour à la liste</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title h5 mb-0">Ajouter une Nouvelle Filière</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.majors.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">Titre de la Filière</label>
                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Ex: Génie Informatique">
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug (optionnel, sera généré automatiquement si vide)</label>
                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Ex: genie-informatique">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category" class="form-label">Catégorie</label>
                    <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                        <option value="" disabled selected>Choisir une catégorie...</option>
                        <option value="cycle_ingenieur" {{ old('category') == 'cycle_ingenieur' ? 'selected' : '' }}>Cycle Ingénieur</option>
                        <option value="preparatoire" {{ old('category') == 'preparatoire' ? 'selected' : '' }}>Classes Préparatoires</option>
                        <option value="formation_continue" {{ old('category') == 'formation_continue' ? 'selected' : '' }}>Formation Continue</option>
                        <option value="doctorat" {{ old('category') == 'doctorat' ? 'selected' : '' }}>Doctorat</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" required placeholder="Description détaillée de la filière...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="source_url" class="form-label">Site Officiel (Source URL)</label>
                    <input type="url" name="source_url" id="source_url" class="form-control @error('source_url') is-invalid @enderror" value="{{ old('source_url', 'https://ensa.uit.ac.ma') }}" required placeholder="Ex: https://ensa.uit.ac.ma">
                    @error('source_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="video_url" class="form-label">Lien de la vidéo de présentation (YouTube ou autre URL directe)</label>
                    <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" value="{{ old('video_url') }}" placeholder="Ex: https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                    <div class="form-text text-muted">Vous pouvez coller un lien YouTube (ex: watch?v=... ou youtu.be/...) ou un lien direct de vidéo .mp4.</div>
                    @error('video_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Créer la Filière</button>
                    <a href="{{ route('admin.majors.index') }}" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
