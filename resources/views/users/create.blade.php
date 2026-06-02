@extends('layouts.app')

@section('title', 'Create User')

@section('content')

<section class="p-4">

    <div class="form-card-dark mx-auto rounded-4 p-4" style="max-width: 700px;">

        <h1 class="text-white fw-bold mb-4">Create User</h1>

        {{-- Validation Errors --}}
        @if($errors->any())
        <div class="alert alert-danger rounded-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label text-light">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="form-control form-control-dark rounded-3">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="form-control form-control-dark rounded-3">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Password</label>
                <input type="password" name="password"
                       class="form-control form-control-dark rounded-3">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control form-control-dark rounded-3">
            </div>

            <div class="mb-4">
                <label class="form-label text-light">Role</label>
                <select name="role" class="form-select form-control-dark rounded-3">
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-3 fw-semibold rounded-3">
                Create User
            </button>

        </form>

    </div>

</section>

@endsection