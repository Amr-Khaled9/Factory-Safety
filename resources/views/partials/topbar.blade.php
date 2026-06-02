<header class="topbar d-flex align-items-center justify-content-between bg-white border-bottom px-4" style="height: 80px;">

    <!-- Left -->
    <div>
        <h2 class="fs-5 fw-bold text-dark mb-0">Safety Command Center</h2>
        <p class="text-muted small mb-0">Monitor workplace safety and AI detections</p>
    </div>

    <!-- Right -->
    <div class="d-flex align-items-center gap-3">

        <!-- Notifications -->
        <div class="notification-box position-relative">
            <livewire:notifications-dropdown wire:poll.1s />
        </div>

        <!-- User Dropdown -->
        <div class="dropdown">

            <button class="btn d-flex align-items-center gap-2 rounded-3 px-3 py-2 user-btn" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">

                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=1e88ff&color=fff"
                    alt="User" class="rounded-circle" width="40" height="40">

                <div class="text-start">
                    <h6 class="mb-0 small fw-semibold">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">{{ auth()->user()->role ?? 'Admin' }}</small>
                </div>

                <i class="fa-solid fa-chevron-down text-muted small"></i>

            </button>

            <!-- Dropdown Menu -->
            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2">
                <li>
                    <form action="{{ route('web.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item d-flex align-items-center gap-2 rounded-2 text-danger">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </li>
            </ul>

        </div>

    </div>

</header>