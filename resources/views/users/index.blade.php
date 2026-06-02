@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<section class="p-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

        <div>
            <h1 class="fw-bold">Users Management</h1>
            <p class="text-muted mb-0">Manage system users and permissions</p>
        </div>

        <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Add User
        </a>

    </div>

    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert alert-success rounded-3">
        {{ session('success') }}
    </div>
    @endif

    <!-- TABLE -->
    <div class="table-dark-container rounded-4 overflow-hidden">

        <table class="table table-dark table-hover mb-0 align-middle">

            <thead class="table-header-dark">
                <tr>
                    <th>ID</th>
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

                    <td>#{{ $user->id }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->role === 'admin')
                        <span class="badge bg-danger rounded-pill px-3 py-2">{{ $user->role }}</span>
                        @else
                        <span class="badge bg-primary rounded-pill px-3 py-2">{{ $user->role }}</span>
                        @endif
                    </td>

                    <td>{{ $user->created_at->format('d M Y') }}</td>

                    <td>
                        <div class="d-flex align-items-center gap-3">

                            <a href="{{ route('users.show', $user) }}" class="text-white">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="{{ route('users.edit', $user) }}" class="text-white">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <form
                                action="{{ route('users.destroy', $user->id) }}"
                                method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this user?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-link text-danger p-0">
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