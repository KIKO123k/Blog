@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Manage Posts</h1>
    
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($posts as $post)
            <tr>
                <td><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></td>
                <td>{{ $post->user->name }}</td>
                <td>{{ $post->category?->name ?? '-' }}</td>
                <td>{{ $post->created_at->format('Y-m-d') }}</td>
                <td>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this post?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $posts->links() }}
</div>
@endsection