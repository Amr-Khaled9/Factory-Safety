@extends('layouts.app')

@section('title', 'Settings')
@section('page-title', 'My Account')
@section('page-subtitle', 'Personal information & system access')

@section('content')

<section class="p-4" style="max-width:720px">

    <!-- Profile -->
    <div class="card border-0 p-4 mb-3">
        <div class="d-flex align-items-center gap-4 mb-4">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&bold=true&size=80"
                 class="rounded-circle" width="64" height="64" alt="{{ $user->name }}">
            <div>
                <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
                <span class="badge rounded-pill fw-semibold px-3"
                      style="background:{{ $user->role === 'admin' ? 'var(--danger-bg)' : 'var(--brand-light)' }};
                             color:{{ $user->role === 'admin' ? 'var(--danger)' : 'var(--brand)' }}">
                    {{ ucfirst($user->role ?? 'user') }}
                </span>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-sm-6">
                <div class="p-3 rounded-3" style="background:var(--bg);border:1px solid var(--border)">
                    <div class="text-muted small mb-1">Email</div>
                    <div class="fw-semibold small">{{ $user->email }}</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="p-3 rounded-3" style="background:var(--bg);border:1px solid var(--border)">
                    <div class="text-muted small mb-1">Member Since</div>
                    <div class="fw-semibold small">{{ $user->created_at->format('d M Y') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- System Info -->
    <div class="card border-0 p-4 mb-3">
        <h6 class="fw-bold mb-3">System Status</h6>
        <div class="d-flex align-items-center gap-3">
            <span class="rounded-circle bg-success d-inline-block" style="width:10px;height:10px"></span>
            <span class="small fw-semibold">System Active</span>
            <span class="text-muted small ms-auto">Last login: {{ now()->format('d M Y, H:i') }}</span>
        </div>
    </div>

    <!-- Logout -->
    <div class="card border-0 p-4" style="border-left:4px solid var(--danger) !important">
        <h6 class="fw-bold mb-1">Danger Zone</h6>
        <p class="text-muted small mb-3">Signing out will end your current session.</p>
        <form method="POST" action="{{ route('web.logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger px-4">
                <i class="fa-solid fa-right-from-bracket me-2"></i>Sign Out
            </button>
        </form>
    </div>

</section>

@endsection