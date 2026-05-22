<header class="topbar">

    <!-- Left -->
    <div class="topbar-left">
        <h2>Safety Command Center</h2>
        <p>Monitor workplace safety and AI detections</p>
    </div>

    <!-- Right -->
    <div class="top-right">

        <!-- Notifications -->
        <div class="notification-box">
            <livewire:notifications-dropdown wire:poll.1s />
        </div>

        <!-- User Dropdown -->
        <div class="user-dropdown">

            <button class="user-btn" onclick="toggleDropdown()">

                <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=1e88ff&color=fff"
                    alt="User">

                <div class="user-info">
                    <h4>{{ auth()->user()->name }}</h4>
                    <p>
                        {{ auth()->user()->role ?? 'Admin' }}
                    </p>
                </div>

                <i class="fa-solid fa-chevron-down arrow-icon"></i>

            </button>

            <!-- Dropdown Menu -->
            <div class="dropdown-menu" id="dropdownMenu">

                <a href="#">
                    <i class="fa-regular fa-user"></i>
                    Profile
                </a>

                <a href="#">
                    <i class="fa-solid fa-gear"></i>
                    Settings
                </a>

                <form action="{{ route('web.logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="logout-btn">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

</header>