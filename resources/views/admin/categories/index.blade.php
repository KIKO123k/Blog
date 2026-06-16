@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Manage Categories</h1>
    
    <div class="card mt-4">
        <div class="card-header">Add New Category</div>
        <div class="card-body">
            <form action="{{ route('admin.categories.store') }}" method="POST" class="row g-3">
                @csrf
                <div class="col-md-4">
                    <input type="text" name="name" class="form-control" placeholder="Category name" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="slug" class="form-control" placeholder="Slug (optional)">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                </div>
            </form>
        </div>
    </div>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Slug</th>
                <th>Posts</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->posts_count }}</td>
                <td>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection