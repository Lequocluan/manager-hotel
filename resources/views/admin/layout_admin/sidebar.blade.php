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
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="false" aria-controls="collapseTable">
            <i class="fas fa-fw fa-table"></i>
            <span>Phòng</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar" style="">
            <div class="bg-white py-2 collapse-inner ">
            <a class="collapse-item" href="{{ route('room-types.index')}}">Loại phòng</a>
            <a class="collapse-item" href="{{ route('rooms.index') }}">Danh sách phòng</a>
            </div>
        </div>        
    </li>
    <li class="nav-item {{ request()->routeIs('services*') ? 'active' : '' }}">
        <a href="{{ route('services.index') }}" class="nav-link">
        <i class="fas fa-concierge-bell"></i>
        <span>Dịch vụ</span></a>
    </li>
  </ul>