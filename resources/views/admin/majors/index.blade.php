@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Filières</h1>
        <a href="{{ route('admin.majors.create') }}" class="btn btn-primary">Ajouter une Filière</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>URL Vidéo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($majors as $major)
                        <tr>
                            <td>
                                <strong>{{ $major->title }}</strong>
                                <br>
                                <small class="text-muted">{{ $major->slug }}</small>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $major->category }}</span>
                            </td>
                            <td>
                                @if($major->video_url)
                                    <a href="{{ $major->video_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 250px;" title="{{ $major->video_url }}">
                                        {{ $major->video_url }}
                                    </a>
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.majors.edit', $major) }}" class="btn btn-sm btn-outline-primary">Modifier</a>
                                <form action="{{ route('admin.majors.destroy', $major) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                Aucune filière enregistrée pour le moment.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $majors->links() }}
    </div>
</div>
@endsection
