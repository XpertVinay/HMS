@php
    $role = session('account', 'member');
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<div class="sidebar fixed top-0 left-0 h-full z-[99] bg-[#1e1b4b] text-white shadow-2xl flex flex-col py-6 px-4">
    <div class="logo-details flex items-center justify-center mb-8 px-2">
        <a href="{{ route('home') }}" class="block w-full transition-transform hover:scale-105">
            <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10 shadow-lg flex justify-center items-center h-[70px]">
                <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="logo" class="max-h-10 w-auto object-contain drop-shadow-md">
            </div>
        </a>
    </div>
    
    <div class="mb-4 px-3 text-xs font-bold text-indigo-300 uppercase tracking-wider opacity-80">
        Menu
    </div>

    <ul class="nav-links sidebar-scroll flex-1 overflow-y-auto space-y-1.5 pr-1">
        @if($role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="nav-item {{ str_contains($currentRoute, 'admin.dashboard') ? 'active-nav' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('admin.announcements.index') }}" class="nav-item {{ str_contains($currentRoute, 'announcements') ? 'active-nav' : '' }}"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="{{ route('admin.maintenance.index') }}" class="nav-item {{ str_contains($currentRoute, 'maintenance') ? 'active-nav' : '' }}"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Maintenance</span></a></li>
            <li><a href="{{ route('admin.helpdesk.index') }}" class="nav-item {{ str_contains($currentRoute, 'helpdesk') ? 'active-nav' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            <li><a href="{{ route('admin.members.index') }}" class="nav-item {{ str_contains($currentRoute, 'members') ? 'active-nav' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
            <li><a href="{{ route('admin.staff.index') }}" class="nav-item {{ str_contains($currentRoute, 'admin.staff') ? 'active-nav' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
            <li><a href="{{ route('admin.residents.index') }}" class="nav-item {{ str_contains($currentRoute, 'residents') ? 'active-nav' : '' }}"><i class='bx bx-home-smile'></i><span class="links_name">Residents</span></a></li>
            <li><a href="{{ route('admin.vendors.index') }}" class="nav-item {{ str_contains($currentRoute, 'vendors') ? 'active-nav' : '' }}"><i class='bx bx-store-alt'></i><span class="links_name">Vendors</span></a></li>
            <li><a href="{{ route('admin.properties.index') }}" class="nav-item {{ str_contains($currentRoute, 'properties') ? 'active-nav' : '' }}"><i class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
            <li><a href="{{ route('admin.donors.index') }}" class="nav-item {{ str_contains($currentRoute, 'donors') ? 'active-nav' : '' }}"><i class='bx bx-donate-heart'></i><span class="links_name">Donors</span></a></li>
            <li><a href="{{ route('admin.sponsors.index') }}" class="nav-item {{ str_contains($currentRoute, 'sponsors') ? 'active-nav' : '' }}"><i class='bx bx-star'></i><span class="links_name">Sponsors</span></a></li>
            <li><a href="{{ route('admin.events.index') }}" class="nav-item {{ str_contains($currentRoute, 'events') ? 'active-nav' : '' }}"><i class='bx bx-calendar-event'></i><span class="links_name">Events</span></a></li>
            <li><a href="{{ route('admin.gallery.index') }}" class="nav-item {{ str_contains($currentRoute, 'gallery') ? 'active-nav' : '' }}"><i class='bx bx-image'></i><span class="links_name">Gallery</span></a></li>
            <li><a href="{{ route('admin.solid.index') }}" class="nav-item {{ str_contains($currentRoute, 'solid.index') || str_contains($currentRoute, 'solid.approve') ? 'active-nav' : '' }}"><i class='bx bx-check-square'></i><span class="links_name">SOLID Approvals</span></a></li>
            <li><a href="{{ route('admin.solid.settings') }}" class="nav-item {{ str_contains($currentRoute, 'solid.settings') ? 'active-nav' : '' }}"><i class='bx bx-cog'></i><span class="links_name">SOLID Settings</span></a></li>
            <li><a href="{{ route('admin.community.approvals') }}" class="nav-item {{ str_contains($currentRoute, 'community') ? 'active-nav' : '' }}"><i class='bx bx-check-double'></i><span class="links_name">Comm. Approvals</span></a></li>

        @elseif($role === 'member')
            <li><a href="{{ route('member.dashboard') }}" class="nav-item {{ str_contains($currentRoute, 'member.dashboard') ? 'active-nav' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('member.announcements.index') }}" class="nav-item {{ str_contains($currentRoute, 'announcements') ? 'active-nav' : '' }}"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="{{ route('member.maintenance.index') }}" class="nav-item {{ str_contains($currentRoute, 'maintenance') ? 'active-nav' : '' }}"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Maintenance</span></a></li>
            <li><a href="{{ route('member.solid.index') }}" class="nav-item {{ str_contains($currentRoute, 'solid') ? 'active-nav' : '' }}"><i class='bx bx-file'></i><span class="links_name">SOLID Approvals</span></a></li>
            <li><a href="{{ route('member.helpdesk.index') }}" class="nav-item {{ str_contains($currentRoute, 'helpdesk') ? 'active-nav' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            <li><a href="{{ route('member.community.feed') }}" class="nav-item {{ str_contains($currentRoute, 'community') ? 'active-nav' : '' }}"><i class='bx bx-world'></i><span class="links_name">Community Feed</span></a></li>

        @elseif($role === 'staff')
            <li><a href="{{ route('staff.dashboard') }}" class="nav-item {{ str_contains($currentRoute, 'staff.dashboard') ? 'active-nav' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('staff.helpdesk.index') }}" class="nav-item {{ str_contains($currentRoute, 'helpdesk') ? 'active-nav' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            <li><a href="{{ route('staff.members.index') }}" class="nav-item {{ str_contains($currentRoute, 'members') ? 'active-nav' : '' }}"><i class='bx bx-user'></i><span class="links_name">Members (Owners)</span></a></li>
            <li><a href="{{ route('staff.residents.index') }}" class="nav-item {{ str_contains($currentRoute, 'residents') ? 'active-nav' : '' }}"><i class='bx bx-group'></i><span class="links_name">Residents (Tenants)</span></a></li>
            <li><a href="{{ route('staff.properties.index') }}" class="nav-item {{ str_contains($currentRoute, 'properties') ? 'active-nav' : '' }}"><i class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
            <li><a href="{{ route('staff.community.moderation') }}" class="nav-item {{ str_contains($currentRoute, 'community') ? 'active-nav' : '' }}"><i class='bx bx-check-shield'></i><span class="links_name">Comm. Moderation</span></a></li>
            <li><a href="{{ route('staff.solid.index') }}" class="nav-item {{ str_contains($currentRoute, 'solid') ? 'active-nav' : '' }}"><i class='bx bx-shield-quarter'></i><span class="links_name">SOLID Verification</span></a></li>

        @elseif($role === 'super_admin')
            <li><a href="{{ route('super_admin.dashboard') }}" class="nav-item {{ str_contains($currentRoute, 'super_admin.dashboard') ? 'active-nav' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
        @endif
    </ul>
</div>

<style>
    /* Premium Sidebar Link Styles */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 12px 16px;
        border-radius: 12px;
        color: rgba(255, 255, 255, 0.65);
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .nav-item i {
        min-width: 36px;
        font-size: 20px;
        transition: transform 0.3s ease;
    }
    
    .nav-item:hover {
        background: rgba(255, 255, 255, 0.08);
        color: #ffffff;
        text-decoration: none;
        transform: translateX(4px);
    }
    
    .nav-item:hover i {
        transform: scale(1.1);
    }
    
    .active-nav {
        background: linear-gradient(135deg, var(--primary-color), #6366f1) !important;
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(var(--primary-color), 0.4);
        font-weight: 600;
    }
    
    .sidebar.close .links_name {
        display: none;
    }
    
    .sidebar.close .nav-item {
        justify-content: center;
        padding: 12px 0;
    }
    
    .sidebar.close .nav-item i {
        min-width: auto;
    }
</style>
