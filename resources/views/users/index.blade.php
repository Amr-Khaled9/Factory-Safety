@extends('layouts.app')

@section('title', 'Users Management')
@section('page-title', 'Users Management')
@section('page-subtitle', 'Manage system users and permissions')

@section('content')

<section class="p-4">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
        <div>
            <h1 class="fw-bold mb-1" style="font-size:26px">Users</h1>
            <p class="text-muted small mb-0">{{ $users->total() }} total users</p>
        </div>
        <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-2 fw-semibold">
            <i class="fa-solid fa-plus"></i> Add User
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success rounded-3 mb-4">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    </div>
    @endif

    <div class="table-dark-container">
        <table class="users-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="color:var(--dark-muted);font-family:var(--mono)">#{{ $user->id }}</td>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td style="color:var(--dark-muted)">{{ $user->email }}</td>
                    <td>
                        @if($user->role === 'admin')
                        <span class="badge rounded-pill" style="background:var(--danger-bg);color:var(--danger);padding:5px 12px">
                            Admin
                        </span>
                        @else
                        <span class="badge rounded-pill" style="background:rgba(37,99,235,.15);color:#60a5fa;padding:5px 12px">
                            User
                        </span>
                        @endif
                    </td>
                    <td style="color:var(--dark-muted);font-size:13px">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('users.show', $user) }}" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('users.edit', $user) }}" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                  onsubmit="return confirm('Delete this user?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>

</section>

@endsection