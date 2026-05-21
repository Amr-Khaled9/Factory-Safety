@extends('layouts.app')

@section('title', 'Settings')

@section('content')

<section class="settings">

    <div class="settings-header">
        <h1>My Account</h1>
        <p>Personal information & system access</p>
    </div>

    <!-- USER INFO -->
    <div class="settings-card">

        <h3>Profile Info</h3>

        <div class="info">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>

            <p><strong>Role:</strong>
                {{ $user->role ?? 'User' }}
            </p>

            <p><strong>Joined:</strong>
                {{ $user->created_at->format('Y-m-d') }}
            </p>
        </div>

    </div>

    <!-- SYSTEM INFO -->
    <div class="settings-card">

        <h3>System Info</h3>

        <div class="info">
            <p><strong>Status:</strong> Active</p>
            <p><strong>Login Time:</strong> {{ now() }}</p>
        </div>

    </div>

    <!-- LOGOUT -->
    <div class="settings-card danger">

        <h3>Account Actions</h3>

        <form method="POST" action="{{ route('web.logout') }}">
            @csrf

            <button type="submit" class="logout-btn">
                Logout
            </button>

        </form>

    </div>

</section>

@endsection