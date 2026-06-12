@php
    $role = session('account', 'member');
    $currentRoute = request()->route() ? request()->route()->getName() : '';
@endphp

<div class="sidebar">
    <style>
        .sidebar .nav-links li a .toggle-icon {
            margin-left: auto;
            transition: transform 0.3s;
        }

        .sidebar.close .nav-links li a .toggle-icon {
            display: none !important;
        }

        .sidebar .nav-links li a[aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }
    </style>
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
        @if(in_array($role, ['admin', 'member', 'staff', 'vendor']))
            <li><a href="{{ route($role . '.dashboard') }}"
                    class="{{ str_contains($currentRoute, $role . '.dashboard') ? 'active' : '' }}"><i
                        class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>

            @php
                $orgId = $activeOrg->id ?? null;
                $dashboardMenus = [];
                if ($orgId) {
                    $dashboardMenus = \App\Models\PortalMenu::where('organization_id', $orgId)
                        ->whereIn('visibility', ['dashboard', 'both'])
                        ->with([
                            'children' => function ($q) {
                                $q->whereIn('visibility', ['dashboard', 'both'])->orderBy('order');
                            }
                        ])
                        ->whereNull('parent_id')
                        ->orderBy('order')
                        ->get()
                        ->filter(function ($menu) use ($role) {
                            return empty($menu->roles) || in_array($role, $menu->roles);
                        });
                }
            @endphp

            @foreach($dashboardMenus as $parent)
                @php
                    $hasAllowedChild = false;
                    foreach ($parent->children as $child) {
                        if (empty($child->roles) || in_array($role, $child->roles)) {
                            $hasAllowedChild = true;
                            break;
                        }
                    }
                @endphp
                @if(count($parent->children) == 0 || $hasAllowedChild)
                    @if(count($parent->children) > 0)
                        @php
                            $isParentActive = false;
                            foreach ($parent->children as $child) {
                                $cleanRoute = str_replace('admin.', '', $child->route_name);
                                if ($child->route_name && str_contains($currentRoute, $cleanRoute)) {
                                    $isParentActive = true;
                                    break;
                                }
                            }
                        @endphp
                        <li class="nav-item-dropdown">
                            <a class="nav-link" data-toggle="collapse" href="#collapseMenu{{ $parent->id }}" role="button"
                                aria-expanded="{{ $isParentActive ? 'true' : 'false' }}" aria-controls="collapseMenu{{ $parent->id }}">
                                <i class='bx {{ $parent->icon ?? 'bx-folder' }}'></i>
                                <span class="links_name">{{ $parent->title }}</span>
                                <i class='bx bx-chevron-down toggle-icon ml-auto'></i>
                            </a>
                            <ul class="collapse list-unstyled {{ $isParentActive ? 'show' : '' }}" id="collapseMenu{{ $parent->id }}"
                                style="padding-left: 25px; margin-bottom: 0;">
                                @foreach($parent->children as $child)
                                    @if(empty($child->roles) || in_array($role, $child->roles))
                                        @php
                                            $cleanRoute = str_replace('admin.', '', $child->route_name);
                                            $routeName = $child->route_name ? $role . '.' . $cleanRoute : '#';
                                        @endphp
                                        <li>
                                            <a href="{{ $child->route_name && Route::has($routeName) ? route($routeName) : url($child->url) }}"
                                                class="{{ $child->route_name && str_contains($currentRoute, $cleanRoute) ? 'active' : '' }}">
                                                <span class="links_name" style="font-size: 13px;">{{ $child->title }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @else
                        @php
                            $cleanRoute = str_replace('admin.', '', $parent->route_name);
                            $routeName = $parent->route_name ? $role . '.' . $cleanRoute : '#';
                        @endphp
                        <li>
                            <a href="{{ $parent->route_name && Route::has($routeName) ? route($routeName) : url($parent->url) }}"
                                class="{{ $parent->route_name && str_contains($currentRoute, $cleanRoute) ? 'active' : '' }}">
                                <i class='bx {{ $parent->icon ?? 'bx-circle' }}'></i>
                                <span class="links_name">{{ $parent->title }}</span>
                            </a>
                        </li>
                    @endif
                @endif
            @endforeach

        @elseif($role === 'super_admin')
            <li><a href="{{ route('super_admin.dashboard') }}"
                    class="{{ str_contains($currentRoute, 'super_admin.dashboard') ? 'active' : '' }}"><i
                        class='bx bx-grid-alt'></i><span class="links_name">Dashboard</span></a></li>
            <li><a href="{{ route('super_admin.earnings') }}"
                    class="{{ str_contains($currentRoute, 'super_admin.earnings') ? 'active' : '' }}"><i
                        class='bx bx-money'></i><span class="links_name">Earnings</span></a></li>
            <li><a href="{{ route('super_admin.theme_builder.index') }}"
                    class="{{ str_contains($currentRoute, 'theme_builder') ? 'active' : '' }}"><i
                        class='bx bx-palette'></i><span class="links_name">Theme Builder</span></a></li>
            <li><a href="{{ route('super_admin.cms.index') }}"
                    class="{{ str_contains($currentRoute, 'super_admin.cms') ? 'active' : '' }}"><i
                        class='bx bx-layout'></i><span class="links_name">CMS / Pages</span></a></li>
            <li><a href="{{ route('super_admin.portal_menus.index') }}"
                    class="{{ str_contains($currentRoute, 'portal_menus') ? 'active' : '' }}"><i
                        class='bx bx-menu-alt-right'></i><span class="links_name">Portal Menus</span></a></li>
            <li><a href="{{ route('super_admin.menu_config.index') }}"
                    class="{{ str_contains($currentRoute, 'menu_config') ? 'active' : '' }}"><i class='bx bx-menu'></i><span
                        class="links_name">Menu Config</span></a></li>
            <li><a href="{{ route('super_admin.industries.index') }}"
                    class="{{ str_contains($currentRoute, 'industries') ? 'active' : '' }}"><i
                        class='bx bx-building-house'></i><span class="links_name">Industries</span></a></li>
            <li><a href="{{ route('super_admin.roles_permissions.index') }}"
                    class="{{ str_contains($currentRoute, 'roles_permissions') ? 'active' : '' }}"><i
                        class='bx bx-shield-quarter'></i><span class="links_name">Roles & Perms</span></a></li>

            @if(session()->has('managed_org_id'))
                <li
                    style="padding: 10px; color: #fff; text-transform: uppercase; font-size: 11px; font-weight: bold; margin-top: 10px; border-top: 1px solid rgba(255,255,255,0.1);">
                    Managing: {{ Str::limit(session('managed_org_name'), 20) }}</li>
                <li><a href="{{ route('admin.admins.index') }}"
                        class="{{ str_contains($currentRoute, 'admin.admins') ? 'active' : '' }}"><i
                            class='bx bx-shield'></i><span class="links_name">Admins</span></a></li>
                <li><a href="{{ route('admin.members.index') }}"
                        class="{{ str_contains($currentRoute, 'members') ? 'active' : '' }}"><i class='bx bx-list-ul'></i><span
                            class="links_name">Members</span></a></li>
                <li><a href="{{ route('admin.staff.index') }}"
                        class="{{ str_contains($currentRoute, 'admin.staff') ? 'active' : '' }}"><i
                            class='bx bx-list-ul'></i><span class="links_name">Staff</span></a></li>
                <li><a href="{{ route('admin.residents.index') }}"
                        class="{{ str_contains($currentRoute, 'residents') ? 'active' : '' }}"><i
                            class='bx bx-home-smile'></i><span class="links_name">Residents</span></a></li>
                <li><a href="{{ route('admin.vendors.index') }}"
                        class="{{ str_contains($currentRoute, 'vendors') ? 'active' : '' }}"><i
                            class='bx bx-store-alt'></i><span class="links_name">Vendors</span></a></li>
                <li><a href="{{ route('admin.properties.index') }}"
                        class="{{ str_contains($currentRoute, 'properties') ? 'active' : '' }}"><i
                            class='bx bx-building-house'></i><span class="links_name">Properties</span></a></li>
                <li><a href="{{ route('admin.roles_permissions.index') }}"
                        class="{{ str_contains($currentRoute, 'admin.roles_permissions') ? 'active' : '' }}"><i
                            class='bx bx-shield-quarter'></i><span class="links_name">Roles & Perms</span></a></li>
            @endif
        @endif
    </ul>
</div>