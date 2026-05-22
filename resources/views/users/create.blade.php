@extends('layouts.app')

@section('title', 'Create User')

@section('content')

<section class="form-page">

    <div class="form-card">

        <h1>Create User</h1>
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
            action="{{ route('users.store') }}"
            method="POST">

            @csrf

            <div class="form-group">
                <label>Name</label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}">
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

                    <option value="admin">Admin</option>

                    <option value="user">User</option>

                </select>
            </div>

            <button type="submit" class="save-btn">
                Create User
            </button>

        </form>

    </div>

</section>

@endsection