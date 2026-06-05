@php
    $role = session('account', 'member');
    $username = session('username', 'User');
    $displayName = session('display_name', $username);
@endphp

<nav class="sticky top-0 z-50 glass-navbar flex justify-between items-center px-6 lg:px-10 py-4 mb-8">
    <div class="sidebar-button flex items-center gap-4">
        <i class='bx bx-menu sidebarBtn text-3xl text-slate-600 hover:text-indigo-600 cursor-pointer transition-colors p-1 rounded-lg hover:bg-slate-100'></i>
        <span class="dashboard text-xl lg:text-2xl font-bold tracking-tight text-slate-800">{{ ucfirst($role) }} Portal</span>
    </div>
    
    <div class="profile-details dropdown bg-white py-1.5 px-2 pr-4 rounded-full border border-slate-200 shadow-sm hover:shadow-md hover:border-slate-300 transition-all flex items-center gap-3 cursor-pointer" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <div class="avatar w-9 h-9 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-inner" style="background: linear-gradient(135deg, var(--primary-color) 0%, #8b5cf6 100%);">
            {{ strtoupper(substr($displayName, 0, 1)) }}
        </div>
        <span class="admin_name font-semibold text-sm text-slate-700 hidden sm:block">{{ $displayName }}</span>
        <i class='bx bx-chevron-down text-slate-400'></i>
    </div>
    
    <div class="dropdown-menu dropdown-menu-right shadow-xl border border-slate-100 rounded-xl mt-2 overflow-hidden py-1 min-w-[200px]" style="border-radius: 12px;">
        @php
            $profileRoute = match($role) {
                'admin', 'super_admin' => route('admin.profile'),
                'staff' => route('staff.profile'),
                'member' => route('member.profile'),
                'resident' => route('resident.profile'),
                'vendor' => route('vendor.profile'),
                default => '#',
            };
        @endphp
        <div class="px-4 py-3 border-b border-slate-100 mb-1 bg-slate-50">
            <p class="text-sm font-semibold text-slate-800">{{ $displayName }}</p>
            <p class="text-xs text-slate-500 font-medium capitalize">{{ str_replace('_', ' ', $role) }} Account</p>
        </div>
        <a class="dropdown-item py-2.5 text-sm font-medium text-slate-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors flex items-center" href="{{ $profileRoute }}">
            <i class='bx bx-user mr-3 text-lg'></i> My Profile
        </a>
        <div class="dropdown-divider my-1 border-slate-100"></div>
        <a class="dropdown-item py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors flex items-center" href="{{ route('logout') }}">
            <i class='bx bx-log-out mr-3 text-lg'></i> Logout
        </a>
    </div>
</nav>
