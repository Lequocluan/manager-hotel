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
            <span>Dashboard</span>
        </a>
    </li>


    @role('superadmin')
    <li class="nav-item {{ request()->routeIs('manager*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('manager.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Nhân viên</span>
        </a>
    </li>    
    @endrole

    @can('xem-loai-phong')
    <li class="nav-item {{ request()->routeIs('room-types*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('room-types.index') }}">
            <i class="fas fa-layer-group"></i>
            <span>Loại phòng</span>
        </a>
    </li>
    @endcan

    @can('xem-phong')
    <li class="nav-item {{ request()->routeIs('rooms*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('rooms.index') }}">
            <i class="fas fa-hotel"></i>
            <span>Danh sách phòng</span>
        </a>
    </li>
    @endcan

    @can('xem-dich-vu')
    <li class="nav-item {{ request()->routeIs('services*') ? 'active' : '' }}">
        <a href="{{ route('services.index') }}" class="nav-link">
            <i class="fas fa-concierge-bell"></i>
            <span>Dịch vụ</span>
        </a>
    </li>
    @endcan

    @can('them-danh-muc-tin-tuc')
    <li class="nav-item {{ request()->routeIs('news-category*') ? 'active' : '' }}">
        <a href="{{ route('news-category.index') }}" class="nav-link">
            <i class="fas fa-folder-open"></i>
            <span>Danh mục bài viết</span>
        </a>
    </li>
    @endcan

    @can('xem-tin-tuc')
    <li class="nav-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
        <a href="{{ route('news.index')}}" class="nav-link">
            <i class="fas fa-newspaper"></i>
            <span>Bài viết</span>
        </a>
    </li>
    @endcan

    @can('xem-don-dat-phong')
    <li class="nav-item {{ request()->routeIs('booked-rooms*') ? 'active' : '' }}">
        <a href="{{ route('booked-rooms.index') }}" class="nav-link">
            <i class="fas fa-calendar-check"></i>
            <span>Quản lý đặt phòng</span>
        </a>
    </li>
    @endcan

    @can('xem-lien-he')
    <li class="nav-item {{ request()->routeIs('admin.contacts.index') ? 'active' : '' }}">
        <a href="{{ route('admin.contacts.index') }}" class="nav-link">
            <i class="fas fa-comment-dots"></i>
            <span>Phản hồi khách hàng</span>
        </a>
    </li>
    @endcan

    @role('superadmin')
    <li class="nav-item {{ request()->routeIs('roles*') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="nav-link">
            <i class="fas fa-user-shield"></i>
            <span>Vai trò</span>
        </a>
    </li>
    @endrole

    @role('superadmin')
    <li class="nav-item {{ request()->routeIs('permissions*') ? 'active' : '' }}">
        <a href="{{ route('permissions.index') }}" class="nav-link">
            <i class="fas fa-key"></i>
            <span>Quyền truy cập</span>
        </a>
    </li>
    @endrole
</ul>
