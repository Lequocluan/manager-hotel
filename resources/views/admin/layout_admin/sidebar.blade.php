<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
      <div class="sidebar-brand-icon">
        <img src="/admin_asset/img/logo.png">
      </div>
      <div class="sidebar-brand-text mx-3">HAVANA</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
    </li>
    <li class="nav-item {{ request()->routeIs('manager*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.index') }}">
            <i class="fas fa-user"></i>
          <span>Nhân viên</span></a>
    </li> 
  </ul>