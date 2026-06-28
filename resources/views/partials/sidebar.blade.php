<aside class="sidebar">

    <div class="logo">
        <i class="fa-solid fa-shield-halved"></i>
        <h2>
            FactorySafe
            <span>Command Center</span>
        </h2>
    </div>

    <div class="menu-title">Main Menu</div>

    <ul class="menu">
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-table-columns"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
            <a href="{{ route('reports.index') }}">
                <i class="fa-regular fa-clipboard"></i>
                <span>Safety Reports</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('settings') ? 'active' : '' }}">
            <a href="{{ route('settings') }}">
                <i class="fa-solid fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <div class="menu-title">Detection Modules</div>

    <ul class="menu">
        <li class="{{ request()->routeIs('ppe.*') ? 'active' : '' }}">
            <a href="{{ route('ppe.index') }}">
                <i class="fa-solid fa-hard-hat"></i>
                <span>PPE Detection</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('gate.*') ? 'active' : '' }}">
            <a href="{{ route('gate.index') }}">
                <i class="fa-solid fa-door-open"></i>
                <span>Gate Monitoring</span>
            </a>
        </li>
    </ul>

    @if(auth()->user()->role == 'admin')
    <div class="menu-title">Management</div>

    <ul class="menu">
        <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a href="{{ route('users.index') }}">
                <i class="fa-solid fa-users"></i>
                <span>Users</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
            <a href="{{ route('vehicles.index') }}">
                <i class="fa-solid fa-car"></i>
                <span>Vehicles</span>
            </a>
        </li>
    </ul>
    @endif

</aside>