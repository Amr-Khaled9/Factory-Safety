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

          <li>
              <i class="fa-solid fa-gear"></i>
              Settings
          </li>
      </ul>

      <div class="menu-title">DETECTION MODULES</div>

      <ul class="menu">
          <li>
              <i class="fa-solid fa-hard-hat"></i>
              Helmet Detection
          </li>

          <li>
              <i class="fa-solid fa-user-check"></i>
              Vest Detection
          </li>

          <li>
              <i class="fa-solid fa-border-all"></i>
              Restricted Areas
          </li>

          <li>
              <i class="fa-solid fa-door-open"></i>
              Gate Monitoring
          </li>
      </ul>
  </aside>