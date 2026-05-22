@extends('layouts.app')

@section('title', 'Edit User')

@section('content')

<section class="form-page">

    <div class="form-card">

        <h1>Edit User</h1>
        {{-- Validation Errors --}}
        @if($errors->any())

        <div class="alert error-alert">

            <ul>

                @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

        @endif
        <form
            action="{{ route('users.update', $user) }}"
            method="POST">

            @csrf
            @method('PUT')

            <div class="form-group">

                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}">

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}">

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password">

            </div>
            <div class="form-group">
                <label>Confirm Password</label>

                <input
                    type="password"
                    name="password_confirmation">
            </div>

            <div class="form-group">

                <label>Role</label>

                <select name="role">

                    <option
                        value="admin"
                        {{ $user->role == 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                    <option
                        value="user"
                        {{ $user->role == 'user' ? 'selected' : '' }}>
                        User
                    </option>

                </select>

            </div>

            <button type="submit" class="save-btn">
                Update User
            </button>

        </form>

    </div>

</section>

@endsection