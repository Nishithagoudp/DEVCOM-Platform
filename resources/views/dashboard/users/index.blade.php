@extends('layouts.front')

@section('content')
<style>
    .theme {
        color: #ff6b6b;
    }
    .btn-theme {
        background-color: #ff6b6b;
        color: white;
    }
    .card {
        border: 1px solid #dee2e6; /* Add a border to the card */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add a shadow effect */
    }
</style>
<div class="container mx-auto mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">User Management</h2>
            <p>Manage system Users</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="{{ route('users.create') }}" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Add User
                </a>
            </div>
        </div>
    </div>

    <div class="card bg-gray-800 p-4 mb-4 mt-3">

        <table class="table table-striped table-hover text-white">
            <thead>
            <tr>
                <th class="text-gray-300">Name</th>
                <th class="text-gray-300">Email</th>
                <th class="text-gray-300">Role</th>
                <th class="text-gray-300">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
            <tr>
                <td class="text-gray-400">{{ $user->name }}</td>
                <td class="text-gray-400">{{ $user->email }}</td>
                <td class="text-gray-400">{{ ucfirst($user->role) }}</td>
                <td>
                    <a href="{{ route('users.show', $user->id) }}" class="theme p-2"><i class="bi bi-eye"></i></a> |
                    <a href="{{ route('users.edit', $user->id) }}" class="theme p-2"><i class="bi bi-pencil"></i></a> |
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="theme p-2  "><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
