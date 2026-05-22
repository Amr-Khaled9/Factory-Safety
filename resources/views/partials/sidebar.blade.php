  <!-- Sidebar -->
  <aside class="sidebar">

      <div class="logo">
          <i class="fa-solid fa-shield-halved"></i>
          <h2>Safety</h2>
      </div>

      <div class="menu-title">MAIN MENU</div>

      <ul class="menu">
          <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
              <a href="{{ route('dashboard') }}">
                  <i class="fa-solid fa-table-columns"></i>
                  Dashboard
              </a>
          </li>

          <li class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
              <a href="{{ route('reports.index') }}">
                  <i class="fa-regular fa-clipboard"></i>
                  Safety Reports
              </a>
          </li>

          <li class="{{ request()->routeIs('settings') ? 'active' : '' }}">
              <a href="{{ route('settings') }}">
                  <i class="fa-solid fa-gear"></i>
                  Settings
              </a>
          </li>
      </ul>

      <div class="menu-title">DETECTION MODULES</div>

      <ul class="menu">
          <li class="{{ request()->routeIs('ppe.*') ? 'active' : '' }}">
              <a href="{{ route('ppe.index') }}">
                  <i class="fa-solid fa-hard-hat"></i>
                  PPE Detection
              </a>
          </li>

          <li class="{{ request()->routeIs('gate.*') ? 'active' : '' }}">
              <a href="{{ route('gate.index') }}">
                  <i class="fa-solid fa-door-open"></i>
                  Gate Monitoring
              </a>
          </li>
      </ul>
      @if(auth()->user()->role == 'admin')
      <!-- MANAGEMENT -->
      <div class="menu-title">MANAGEMENT</div>

      <ul class="menu">

          <li class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
              <a href="{{ route('users.index') }}">
                  <i class="fa-solid fa-users"></i>
                  Users Management
              </a>
          </li>

          <li class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
              <a href="{{ route('vehicles.index') }}">
                  <i class="fa-solid fa-car"></i>
                  Vehicles Management
              </a>
          </li>

      </ul>

      @endif
  </aside>