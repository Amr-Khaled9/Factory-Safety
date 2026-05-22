@extends('layouts.app')

@section('title', 'User Details')

@section('content')

<section class="show-page">

    <div class="show-card">

        <div class="avatar">
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>

        <h1>{{ $user->name }}</h1>

        <p>{{ $user->email }}</p>

        <div class="details">

            <div class="detail-box">
                <span>Role</span>
                <h3>{{ $user->role }}</h3>
            </div>

            <div class="detail-box">
                <span>Created</span>
                <h3>{{ $user->created_at->format('d M Y') }}</h3>
            </div>

        </div>

        <a
            href="{{ route('users.edit', $user) }}"
            class="edit-btn">

            Edit User

        </a>

    </div>

</section>

@endsection