@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<section class="users-page">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1>Users Management</h1>
            <p>Manage system users and permissions</p>
        </div>

        <a href="{{ route('users.create') }}" class="create-btn">
            <i class="fa-solid fa-plus"></i>
            Add User
        </a>

    </div>
    {{-- Success Message --}}
    @if(session('success'))
    <div class="alert success-alert">
        {{ session('success') }}
    </div>
    @endif
    <!-- TABLE -->
    <div class="table-container">

        <table class="users-table">

            <thead>
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
                        <span class="role {{ $user->role }}">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td>{{ $user->created_at->format('d M Y') }}</td>

                    <td class="actions">

                        <a href="{{ route('users.show', $user) }}">
                            <i class="fa-solid fa-eye"></i>
                        </a>

                        <a href="{{ route('users.edit', $user) }}">
                            <i class="fa-solid fa-pen"></i>
                        </a>


                        <form
                            action="{{ route('users.destroy', $user->id) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this user?')">

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="delete-btn">
                                <i class="fa-solid fa-trash"></i>
                            </button>

                        </form>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="pagination">
        {{ $users->links() }}
    </div>

</section>

@endsection