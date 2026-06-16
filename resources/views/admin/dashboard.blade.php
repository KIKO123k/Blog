@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Admin Dashboard</h1>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Posts</h5>
                    <p class="display-4">{{ $stats['posts_count'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="display-4">{{ $stats['users_count'] }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Comments</h5>
                    <p class="display-4">{{ $stats['comments_count'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h3>Recent Posts</h3>
            <ul class="list-group">
                @foreach($stats['recent_posts'] as $post)
                    <li class="list-group-item">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                        <small class="text-muted">by {{ $post->user->name }}</small>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Recent Users</h3>
            <ul class="list-group">
                @foreach($stats['recent_users'] as $user)
                    <li class="list-group-item">
                        {{ $user->name }} ({{ $user->email }})
                        <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'author' ? 'warning' : 'secondary') }}">
                            {{ $user->role }}
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary">Manage Posts</a>
        <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary">Manage Categories</a>
        <a href="{{ route('admin.majors.index') }}" class="btn btn-primary">Manage Majors</a>
    </div>
</div>
@endsection