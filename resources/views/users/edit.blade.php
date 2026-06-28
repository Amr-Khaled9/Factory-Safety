@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')
@section('page-subtitle', 'Update account information and permissions')

@section('content')

<section class="p-4">

    <div class="form-card-dark mx-auto rounded-4 p-4" style="max-width:700px">

        <!-- Header -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&bold=true&size=80"
                 class="rounded-circle" width="48" height="48" alt="{{ $user->name }}">
            <div>
                <h1 class="text-white fw-bold mb-0" style="font-size:22px">{{ $user->name }}</h1>
                <small style="color:var(--dark-muted)">{{ $user->email }}</small>
            </div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger rounded-3 mb-4">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label text-light">Name</label>
                <input type="text" name="name"
                       value="{{ old('name', $user->name) }}"
                       class="form-control form-control-dark rounded-3"
                       placeholder="Full name">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Email</label>
                <input type="email" name="email"
                       value="{{ old('email', $user->email) }}"
                       class="form-control form-control-dark rounded-3"
                       placeholder="email@example.com">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">
                    New Password
                    <small style="color:var(--dark-muted);font-weight:400"> — leave blank to keep current</small>
                </label>
                <input type="password" name="password"
                       class="form-control form-control-dark rounded-3"
                       placeholder="••••••••">
            </div>

            <div class="mb-3">
                <label class="form-label text-light">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="form-control form-control-dark rounded-3"
                       placeholder="••••••••">
            </div>

            <div class="mb-4">
                <label class="form-label text-light">Role</label>
                <select name="role" class="form-select form-control-dark rounded-3">
                    <option value="admin"  {{ $user->role == 'admin'  ? 'selected' : '' }}>Admin</option>
                    <option value="user"   {{ $user->role == 'user'   ? 'selected' : '' }}>User</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('users.index') }}"
                   class="btn fw-semibold py-3 flex-fill"
                   style="background:var(--dark-surface);color:#e2e8f0;border:1px solid var(--dark-border)">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary fw-semibold py-3 flex-fill">
                    <i class="fa-solid fa-floppy-disk me-2"></i>Save Changes
                </button>
            </div>

        </form>

    </div>

</section>

@endsection