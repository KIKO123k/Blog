@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1>Manage Users</h1>
    
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST" class="d-inline">
                        @csrf @method('PUT')
                        <select name="role" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="author" {{ $user->role === 'author' ? 'selected' : '' }}>Author</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </form>
                </td>
                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                <td>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{ $users->links() }}
</div>
@endsection