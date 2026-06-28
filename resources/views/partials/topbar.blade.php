<header class="topbar">

    <!-- Left -->
    <div>
        <h2>@yield('page-title', 'Safety Command Center')</h2>
        <p>@yield('page-subtitle', 'Monitor workplace safety and AI detections')</p>
    </div>

    <!-- Right -->
    <div class="d-flex align-items-center gap-3">

        <!-- Notifications -->
        <div class="notification-wrapper">
            <livewire:notifications-dropdown wire:poll.1s />
        </div>

        <!-- User Dropdown -->
        <div class="dropdown">

            <button class="user-btn" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">

                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=2563eb&color=fff&bold=true"
                    alt="{{ auth()->user()->name }}" class="rounded-circle">

                <div class="text-start d-none d-md-block">
                    <h6 class="mb-0 small fw-semibold" style="color:var(--text-primary)">{{ auth()->user()->name }}</h6>
                    <small style="color:var(--text-muted); text-transform:capitalize">{{ auth()->user()->role ?? 'User' }}</small>
                </div>

                <i class="fa-solid fa-chevron-down small" style="color:var(--text-muted); font-size:11px"></i>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 p-2 mt-1">
                <li>
                    <form action="{{ route('web.logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="dropdown-item d-flex align-items-center gap-2 rounded-2 text-danger py-2">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>

        </div>

    </div>

</header>