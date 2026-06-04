@php
    $role = session('account', 'member');
    $username = session('username', 'User');
@endphp

<nav>
    <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">{{ ucfirst($role) }} Portal</span>
    </div>
    <div class="profile-details dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="avatar">{{ strtoupper(substr($username, 0, 1)) }}</div>
        <span class="admin_name">{{ $username }}</span>
        <i class='bx bx-chevron-down'></i>
    </div>
    <div class="dropdown-menu dropdown-menu-right shadow-sm" style="border:none; border-radius:8px;">
        @php
            $profileRoute = match($role) {
                'admin', 'super_admin' => route('admin.profile'),
                default => '#',
            };
        @endphp
        <a class="dropdown-item" href="{{ $profileRoute }}"><i class='bx bx-user mr-2'></i>My Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class='bx bx-log-out mr-2'></i>Logout</a>
    </div>
</nav>
