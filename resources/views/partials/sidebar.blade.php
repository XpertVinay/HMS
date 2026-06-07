@php
    $role = session('account', 'member');
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<div class="sidebar">
    <div class="logo-details">
        <a href="{{ route('home') }}">
            @php
                $logoUrl = '/assets/images/businzo_logo.png';
                if (isset($theme)) {
                    // Decide which logo based on theme mode. Sidebar is dark, so usually we'd want logo_dark if available
                    $logoUrl = $theme->logo_dark ?? $theme->logo_light ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png';
                } elseif (isset($activeOrg)) {
                    $logoUrl = $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png';
                }
                
                $finalLogoSrc = (str_starts_with($logoUrl, 'http') || str_starts_with($logoUrl, '/')) 
                    ? $logoUrl 
                    : asset('storage/' . $logoUrl);
            @endphp
            <i><img src="{{ $finalLogoSrc }}" alt="logo"></i>
        </a>
    </div>
    <ul class="nav-links">
        @if($role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}" class="{{ str_contains($currentRoute, 'admin.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            @if(in_array('announcements', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.announcements.index') }}" class="{{ str_contains($currentRoute, 'announcements') ? 'active' : '' }}"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            @endif
            @if(in_array('maintenance', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.maintenance.index') }}" class="{{ str_contains($currentRoute, 'maintenance') ? 'active' : '' }}"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Maintenance</span></a></li>
            @endif
            @if(in_array('helpdesk', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.helpdesk.index') }}" class="{{ str_contains($currentRoute, 'helpdesk') ? 'active' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            @endif
            @if(in_array('members', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.members.index') }}" class="{{ str_contains($currentRoute, 'members') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
            @endif
            @if(in_array('staff', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.staff.index') }}" class="{{ str_contains($currentRoute, 'admin.staff') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
            @endif
            @if(in_array('residents', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.residents.index') }}" class="{{ str_contains($currentRoute, 'residents') ? 'active' : '' }}"><i class='bx bx-home-smile'></i><span class="links_name">Residents</span></a></li>
            @endif
            @if(in_array('vendors', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.vendors.index') }}" class="{{ str_contains($currentRoute, 'vendors') ? 'active' : '' }}"><i class='bx bx-store-alt'></i><span class="links_name">Vendors</span></a></li>
            <li><a href="{{ route('admin.advertisements.index') }}" class="{{ str_contains($currentRoute, 'admin.advertisements') ? 'active' : '' }}"><i class='bx bx-megaphone'></i><span class="links_name">Vendor Ads</span></a></li>
            <li><a href="{{ route('admin.commissions.index') }}" class="{{ str_contains($currentRoute, 'commissions') ? 'active' : '' }}"><i class='bx bx-money'></i><span class="links_name">Commissions</span></a></li>
            @endif
            @if(in_array('properties', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.properties.index') }}" class="{{ str_contains($currentRoute, 'properties') ? 'active' : '' }}"><i class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
            @endif
            @if(in_array('donors', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.donors.index') }}" class="{{ str_contains($currentRoute, 'donors') ? 'active' : '' }}"><i class='bx bx-donate-heart'></i><span class="links_name">Donors</span></a></li>
            @endif
            @if(in_array('sponsors', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.sponsors.index') }}" class="{{ str_contains($currentRoute, 'sponsors') ? 'active' : '' }}"><i class='bx bx-star'></i><span class="links_name">Sponsors</span></a></li>
            @endif
            @if(in_array('events', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.events.index') }}" class="{{ str_contains($currentRoute, 'events') ? 'active' : '' }}"><i class='bx bx-calendar-event'></i><span class="links_name">Events</span></a></li>
            @endif
            @if(in_array('gallery', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.gallery.index') }}" class="{{ str_contains($currentRoute, 'gallery') ? 'active' : '' }}"><i class='bx bx-image'></i><span class="links_name">Gallery</span></a></li>
            @endif
            @if(in_array('solid_approvals', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.solid.index') }}" class="{{ str_contains($currentRoute, 'solid.index') || str_contains($currentRoute, 'solid.approve') ? 'active' : '' }}"><i class='bx bx-check-square'></i><span class="links_name">SOLID Approvals</span></a></li>
            @endif
            @if(in_array('solid_settings', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.solid.settings') }}" class="{{ str_contains($currentRoute, 'solid.settings') ? 'active' : '' }}"><i class='bx bx-cog'></i><span class="links_name">SOLID Settings</span></a></li>
            @endif
            @if(in_array('community_approvals', $activeOrg->enabled_menus))
            <li><a href="{{ route('admin.community.approvals') }}" class="{{ str_contains($currentRoute, 'community') ? 'active' : '' }}"><i class='bx bx-check-double'></i><span class="links_name">Comm. Approvals</span></a></li>
            @endif
            <li><a href="{{ route('admin.theme_settings.edit') }}" class="{{ str_contains($currentRoute, 'theme_settings') ? 'active' : '' }}"><i class='bx bx-palette'></i><span class="links_name">Theme Settings</span></a></li>


        @elseif($role === 'member')
            <li><a href="{{ route('member.dashboard') }}" class="{{ str_contains($currentRoute, 'member.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            @if(in_array('announcements', $activeOrg->enabled_menus))
            <li><a href="{{ route('member.announcements.index') }}" class="{{ str_contains($currentRoute, 'announcements') ? 'active' : '' }}"><i class='bx bx-bell'></i><span class="links_name">Notices</span></a></li>
            @endif
            @if(in_array('maintenance', $activeOrg->enabled_menus))
            <li><a href="{{ route('member.maintenance.index') }}" class="{{ str_contains($currentRoute, 'maintenance') ? 'active' : '' }}"><i class='bx bx-pie-chart-alt-2'></i><span class="links_name">Maintenance</span></a></li>
            @endif
            @if(in_array('solid_approvals', $activeOrg->enabled_menus))
            <li><a href="{{ route('member.solid.index') }}" class="{{ str_contains($currentRoute, 'solid') ? 'active' : '' }}"><i class='bx bx-file'></i><span class="links_name">SOLID Approvals</span></a></li>
            @endif
            @if(in_array('helpdesk', $activeOrg->enabled_menus))
            <li><a href="{{ route('member.helpdesk.index') }}" class="{{ str_contains($currentRoute, 'helpdesk') ? 'active' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            @endif
            @if(in_array('community_approvals', $activeOrg->enabled_menus))
            <li><a href="{{ route('member.community.feed') }}" class="{{ str_contains($currentRoute, 'community') ? 'active' : '' }}"><i class='bx bx-world'></i><span class="links_name">Community Feed</span></a></li>
            @endif
            @if(in_array('vendors', $activeOrg->enabled_menus))
            <li><a href="{{ route('member.vendors.directory') }}" class="{{ str_contains($currentRoute, 'vendors.directory') || str_contains($currentRoute, 'vendors.show') ? 'active' : '' }}"><i class='bx bx-store-alt'></i><span class="links_name">Vendor Directory</span></a></li>
            <li><a href="{{ route('member.vendors.vote.index') }}" class="{{ str_contains($currentRoute, 'vendors.vote') ? 'active' : '' }}"><i class='bx bx-check-double'></i><span class="links_name">Vendor Voting</span></a></li>
            @endif

        @elseif($role === 'staff')
            <li><a href="{{ route('staff.dashboard') }}" class="{{ str_contains($currentRoute, 'staff.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            @if(in_array('helpdesk', $activeOrg->enabled_menus))
            <li><a href="{{ route('staff.helpdesk.index') }}" class="{{ str_contains($currentRoute, 'helpdesk') ? 'active' : '' }}"><i class='bx bx-support'></i><span class="links_name">Helpdesk</span></a></li>
            @endif
            @if(in_array('members', $activeOrg->enabled_menus))
            <li><a href="{{ route('staff.members.index') }}" class="{{ str_contains($currentRoute, 'members') ? 'active' : '' }}"><i class='bx bx-user'></i><span class="links_name">Members (Owners)</span></a></li>
            @endif
            @if(in_array('residents', $activeOrg->enabled_menus))
            <li><a href="{{ route('staff.residents.index') }}" class="{{ str_contains($currentRoute, 'residents') ? 'active' : '' }}"><i class='bx bx-group'></i><span class="links_name">Residents (Tenants)</span></a></li>
            @endif
            @if(in_array('properties', $activeOrg->enabled_menus))
            <li><a href="{{ route('staff.properties.index') }}" class="{{ str_contains($currentRoute, 'properties') ? 'active' : '' }}"><i class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
            @endif
            @if(in_array('community_approvals', $activeOrg->enabled_menus))
            <li><a href="{{ route('staff.community.moderation') }}" class="{{ str_contains($currentRoute, 'community') ? 'active' : '' }}"><i class='bx bx-check-shield'></i><span class="links_name">Comm. Moderation</span></a></li>
            @endif
            @if(in_array('solid_approvals', $activeOrg->enabled_menus))
            <li><a href="{{ route('staff.solid.index') }}" class="{{ str_contains($currentRoute, 'solid') ? 'active' : '' }}"><i class='bx bx-shield-quarter'></i><span class="links_name">SOLID Verification</span></a></li>
            @endif

        @elseif($role === 'vendor')
            <li><a href="{{ route('vendor.dashboard') }}" class="{{ str_contains($currentRoute, 'vendor.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('vendor.advertisements.index') }}" class="{{ str_contains($currentRoute, 'vendor.advertisements') ? 'active' : '' }}"><i class='bx bx-megaphone'></i><span class="links_name">Advertisements</span></a></li>
            <li><a href="{{ route('vendor.services.index') }}" class="{{ str_contains($currentRoute, 'vendor.services') ? 'active' : '' }}"><i class='bx bx-wrench'></i><span class="links_name">Service Requests</span></a></li>
            <li><a href="{{ route('vendor.reviews.index') }}" class="{{ str_contains($currentRoute, 'vendor.reviews') ? 'active' : '' }}"><i class='bx bx-star'></i><span class="links_name">My Reviews</span></a></li>

        @elseif($role === 'super_admin')
            <li><a href="{{ route('super_admin.dashboard') }}" class="{{ str_contains($currentRoute, 'super_admin.dashboard') ? 'active' : '' }}"><i class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('super_admin.earnings') }}" class="{{ str_contains($currentRoute, 'super_admin.earnings') ? 'active' : '' }}"><i class='bx bx-money'></i><span class="links_name">Earnings</span></a></li>
            <li><a href="{{ route('super_admin.theme_builder.index') }}" class="{{ str_contains($currentRoute, 'theme_builder') ? 'active' : '' }}"><i class='bx bx-palette'></i><span class="links_name">Theme Builder</span></a></li>
            <li><a href="{{ route('super_admin.menu_config.index') }}" class="{{ str_contains($currentRoute, 'menu_config') ? 'active' : '' }}"><i class='bx bx-menu'></i><span class="links_name">Menu Config</span></a></li>

            @if(session()->has('managed_org_id'))
                <li style="padding: 10px; color: #fff; text-transform: uppercase; font-size: 11px; font-weight: bold; margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1);">Managing: {{ Str::limit(session('managed_org_name'), 20) }}</li>
                <li><a href="{{ route('admin.admins.index') }}" class="{{ str_contains($currentRoute, 'admin.admins') ? 'active' : '' }}"><i class='bx bx-shield'></i><span class="links_name">Admins</span></a></li>
                <li><a href="{{ route('admin.members.index') }}" class="{{ str_contains($currentRoute, 'members') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Members</span></a></li>
                <li><a href="{{ route('admin.staff.index') }}" class="{{ str_contains($currentRoute, 'admin.staff') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
                <li><a href="{{ route('admin.residents.index') }}" class="{{ str_contains($currentRoute, 'residents') ? 'active' : '' }}"><i class='bx bx-home-smile'></i><span class="links_name">Residents</span></a></li>
                <li><a href="{{ route('admin.vendors.index') }}" class="{{ str_contains($currentRoute, 'vendors') ? 'active' : '' }}"><i class='bx bx-store-alt'></i><span class="links_name">Vendors</span></a></li>
                <li><a href="{{ route('admin.properties.index') }}" class="{{ str_contains($currentRoute, 'properties') ? 'active' : '' }}"><i class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
            @endif
        @endif
    </ul>
</div>
