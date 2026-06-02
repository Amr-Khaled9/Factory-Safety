@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<section class="p-4">

    <div class="mb-4">
        <h1 class="fw-bold">My Account</h1>
        <p class="text-muted">Personal information & system access</p>
    </div>

    <!-- USER INFO -->
    <div class="card border-0 shadow-sm rounded-3 p-4 mb-3">

        <h5 class="fw-semibold mb-3">Profile Info</h5>

        <div>
            <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-2"><strong>Role:</strong> {{ $user->role ?? 'User' }}</p>
            <p class="mb-0"><strong>Joined:</strong> {{ $user->created_at->format('Y-m-d') }}</p>
        </div>

    </div>

    <!-- SYSTEM INFO -->
    <div class="card border-0 shadow-sm rounded-3 p-4 mb-3">

        <h5 class="fw-semibold mb-3">System Info</h5>

        <div>
            <p class="mb-2"><strong>Status:</strong> Active</p>
            <p class="mb-0"><strong>Login Time:</strong> {{ now() }}</p>
        </div>

    </div>

    <!-- LOGOUT -->
    <div class="card border-0 shadow-sm rounded-3 p-4 border-start border-danger border-4">

        <h5 class="fw-semibold mb-3">Account Actions</h5>

        <form method="POST" action="{{ route('web.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger">
                Logout
            </button>
        </form>

    </div>

</section>

@endsection