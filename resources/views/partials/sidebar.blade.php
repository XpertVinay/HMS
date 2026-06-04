@php
    $role = session('account', 'member');
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<div class="sidebar">
    <div class="logo-details">
        <a href="{{ route('home') }}">
            <i><img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="logo"></i>
        </a>
    </div>
    <ul class="nav-links">
        @if($role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="{{ str_contains($currentRoute, 'admin.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('admin.announcements.index') }}" class="{{ str_contains($currentRoute, 'announcements') ? 'active' : '' }}"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="{{ route('admin.maintenance.index') }}" class="{{ str_contains($currentRoute, 'maintenance') ? 'active' : '' }}"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Maintenance</span></a></li>
            <li><a href="{{ route('admin.helpdesk.index') }}" class="{{ str_contains($currentRoute, 'helpdesk') ? 'active' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            <li><a href="{{ route('admin.members.index') }}" class="{{ str_contains($currentRoute, 'members') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
            <li><a href="{{ route('admin.staff.index') }}" class="{{ str_contains($currentRoute, 'admin.staff') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
            <li><a href="{{ route('admin.residents.index') }}" class="{{ str_contains($currentRoute, 'residents') ? 'active' : '' }}"><i class='bx bx-home-smile'></i><span class="links_name">Residents</span></a></li>
            <li><a href="{{ route('admin.vendors.index') }}" class="{{ str_contains($currentRoute, 'vendors') ? 'active' : '' }}"><i class='bx bx-store-alt'></i><span class="links_name">Vendors</span></a></li>
            <li><a href="{{ route('admin.properties.index') }}" class="{{ str_contains($currentRoute, 'properties') ? 'active' : '' }}"><i class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
            <li><a href="{{ route('admin.donors.index') }}" class="{{ str_contains($currentRoute, 'donors') ? 'active' : '' }}"><i class='bx bx-donate-heart'></i><span class="links_name">Donors</span></a></li>
            <li><a href="{{ route('admin.sponsors.index') }}" class="{{ str_contains($currentRoute, 'sponsors') ? 'active' : '' }}"><i class='bx bx-star'></i><span class="links_name">Sponsors</span></a></li>
            <li><a href="{{ route('admin.events.index') }}" class="{{ str_contains($currentRoute, 'events') ? 'active' : '' }}"><i class='bx bx-calendar-event'></i><span class="links_name">Events</span></a></li>
            <li><a href="{{ route('admin.gallery.index') }}" class="{{ str_contains($currentRoute, 'gallery') ? 'active' : '' }}"><i class='bx bx-image'></i><span class="links_name">Gallery</span></a></li>

        @elseif($role === 'member')
            <li><a href="{{ route('member.dashboard') }}" class="{{ str_contains($currentRoute, 'member.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('member.announcements.index') }}" class="{{ str_contains($currentRoute, 'announcements') ? 'active' : '' }}"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            <li><a href="{{ route('member.maintenance.index') }}" class="{{ str_contains($currentRoute, 'maintenance') ? 'active' : '' }}"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Maintenance</span></a></li>
            <li><a href="{{ route('member.helpdesk.index') }}" class="{{ str_contains($currentRoute, 'helpdesk') ? 'active' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>

        @elseif($role === 'staff')
            <li><a href="{{ route('staff.dashboard') }}" class="{{ str_contains($currentRoute, 'staff.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>

        @elseif($role === 'super_admin')
            <li><a href="{{ route('super_admin.dashboard') }}" class="{{ str_contains($currentRoute, 'super_admin.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
        @endif
    </ul>
</div>
