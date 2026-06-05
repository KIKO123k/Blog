@extends('layouts.app')

@section('title', 'Mes Articles')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="page-title gradient-title mb-6">Mes Articles</h1>


    @if($posts->isEmpty())
        <p class="text-muted">Vous n'avez pas encore publié d'articles.</p>
    @else
        <div class="overflow-x-auto">
            <table class="my-posts-table glass w-full text-left border-collapse">
                <thead class="bg-white/70">
                    <tr>
                        <th class="p-5 w-2/5 text-left">Titre</th>
                        <th class="p-5 text-center">Date de publication</th>
                        <th class="p-5 text-center">Vues</th>
                        <th class="p-5 text-center">Note</th>
                        <th class="p-5 text-center">Commentaires</th>
                        <th class="p-5 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr class="border-t align-middle">
                            <td class="p-5 font-medium text-gray-800 break-words w-2/5">{{ $post->title }}</td>
                            <td class="p-5 text-center text-sm text-gray-600 whitespace-nowrap">{{ $post->created_at->format('d/m/Y') }}</td>
                            <td class="p-5 text-center text-sm text-gray-600 whitespace-nowrap">{{ $post->views ?? 0 }}</td>
                            <td class="p-5 text-center text-sm text-gray-600 whitespace-nowrap">
                                <div class="post-rating" style="justify-content: center;">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="star-icon {{ $i <= ($post->rating ?? 0) ? '' : 'empty' }}" viewBox="0 0 24 24" fill="currentColor" style="width: 14px; height: 14px;">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                    @endfor
                                </div>
                            </td>
                            <td class="p-5 text-center text-sm text-gray-600 whitespace-nowrap">{{ $post->comments->count() }}</td>
                <td class="p-5">
                    <div class="actions-row">
                        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary btn-sm">Editer</a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cet article ?')">Supprimer</button>
                        </form>
                        @if($post->comments->isNotEmpty())
                            <button type="button" class="btn btn-secondary btn-sm" onclick="openCommentsModal({{ $post->id }})">Voir commentaires</button>
                        @else
                            <button type="button" class="btn btn-secondary btn-sm" disabled>Aucun commentaire</button>
                        @endif
                    </div>
                </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="pagination-wrapper">
            <ul class="pagination">
                @if($posts->onFirstPage())
                    <li class="disabled"><span>Précédent</span></li>
                @else
                    <li><a href="{{ $posts->previousPageUrl() }}">Précédent</a></li>
                @endif

                @foreach (range(1, $posts->lastPage()) as $i)
                    @if ($i == $posts->currentPage())
                        <li class="active"><span>{{ $i }}</span></li>
                    @else
                        <li><a href="{{ $posts->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endforeach

                @if($posts->hasMorePages())
                    <li><a href="{{ $posts->nextPageUrl() }}">Suivant</a></li>
                @else
                    <li class="disabled"><span>Suivant</span></li>
                @endif
            </ul>
        </div>
    @endif

{{-- Comment Modal --}}
<div id="comments-modal" class="modal hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center" onclick="closeModal(event)">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-4 relative" onclick="event.stopPropagation()">
        <h3 class="text-xl font-bold mb-4">Commentaires</h3>
        <div id="comments-content" class="space-y-4 max-h-80 overflow-y-auto"></div>
        <button class="absolute top-2 right-2 text-gray-600" onclick="closeModal(event)">✕</button>
    </div>
</div>
</div>
<script>
    const postsData = @json($posts->load('comments'));
    function openCommentsModal(postId) {
        const post = postsData.find(p => p.id === postId);
        const container = document.getElementById('comments-content');
        container.innerHTML = '';
        if (!post || !post.comments || post.comments.length === 0) {
            container.innerHTML = `<p class="text-muted">No comments yet.</p>`;
        } else {
            post.comments.forEach(comment => {
                const div = document.createElement('div');
                div.className = 'border-b pb-2';
                const author = comment.author_name || 'Anonyme';
                const body = comment.content || '';
                const date = new Date(comment.created_at).toLocaleDateString();
                div.innerHTML = `
                    <p class="font-medium">${author}</p>
                    <p class="text-sm text-muted">${body}</p>
                    <p class="text-xs text-gray-500">${date}</p>
                `;
                container.appendChild(div);
            });
        }
        document.getElementById('comments-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // prevent scrolling
    }
    function closeModal(e) {
        document.getElementById('comments-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }
</script>

@endsection
