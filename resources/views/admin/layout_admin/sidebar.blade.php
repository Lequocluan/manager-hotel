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
        <i class="fas fa-chart-line"></i>
        <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('manager*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.index') }}">
            <i class="fas fa-users-cog"></i>
          <span>Nhân viên</span></a>
    </li> 

    <li class="nav-item {{ request()->routeIs('room-types*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('room-types.index') }}">
            <i class="fas fa-layer-group"></i>
            <span>Loại phòng</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('rooms*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rooms.index') }}">
            <i class="fas fa-hotel"></i>
            <span>Danh sách phòng</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('services*') ? 'active' : '' }}">
        <a href="{{ route('services.index') }}" class="nav-link">
        <i class="fas fa-concierge-bell"></i>
        <span>Dịch vụ</span></a>
    </li>

    <li class="nav-item {{ request()->routeIs('news-category*') ? 'active' : '' }}">
        <a href="{{ route('news-category.index') }}" class="nav-link">
            <i class="fas fa-folder-open"></i>
            <span>Danh mục bài viết</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
        <a href="{{ route('news.index')}}" class="nav-link">
            <i class="fas fa-newspaper"></i>
            <span>Bài viết</span>
        </a>
    </li>

</ul>
