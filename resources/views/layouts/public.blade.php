<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="{{ $themeMode ?? 'light' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') | {{ $activeOrg->name ?? 'Businzo RCMS' }}</title>
    <link rel="shortcut icon"
        href="{{ $theme->favicon ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @include('partials.theme-variables')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Multi-level dropdown styles */
        .nav-item-dropdown { position: relative; display: inline-block; }
        .nav-dropdown-content { 
            display: none; position: absolute; background-color: var(--navbar-bg); 
            min-w-fit whitespace-nowrap box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); 
            z-index: 1000; border-radius: 8px; border: 1px solid var(--border-color-light); 
            top: 100%; left: 0; padding: 0.5rem 0; min-width: 150px;
        }
        .nav-item-dropdown:hover > .nav-dropdown-content { display: block; }
        .nav-dropdown-content a { 
            color: var(--text-primary); padding: 10px 16px; text-decoration: none; display: block; font-size: 0.875rem; 
        }
        .nav-dropdown-content a:hover { background-color: var(--color-primary); color: white !important; }
        
        .sub-dropdown { position: relative; }
        .sub-dropdown-content { 
            display: none; position: absolute; background-color: var(--navbar-bg); 
            min-width: 150px; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); 
            z-index: 1001; border-radius: 8px; border: 1px solid var(--border-color-light); 
            top: 0; left: 100%; padding: 0.5rem 0;
        }
        .sub-dropdown:hover > .sub-dropdown-content { display: block; }
    </style>
</head>

<body class="font-sans antialiased flex flex-col min-h-screen"
    style="color: var(--text-primary); background: var(--background-secondary);">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 border-b transition-all"
        style="background: var(--navbar-bg); backdrop-filter: blur(12px); box-shadow: var(--navbar-shadow); border-color: var(--border-color-light);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center" style="height: var(--navbar-height, 72px);">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ $theme->logo_light ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}"
                        alt="Logo" class="h-10 w-auto object-contain" style="height: 70px;">
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-2">
                    @php
                        $orgId = $activeOrg->id ?? null;
                        
                        $menus = \App\Models\PortalMenu::where('organization_id', $orgId)
                            ->with(['children' => function($q) { $q->orderBy('order'); }])
                            ->whereNull('parent_id')
                            ->orderBy('order')
                            ->get();
                            
                        if ($menus->isEmpty() && $orgId) {
                            $menus = \App\Models\PortalMenu::whereNull('organization_id')
                                ->with(['children' => function($q) { $q->orderBy('order'); }])
                                ->whereNull('parent_id')
                                ->orderBy('order')
                                ->get();
                        }
                        
                        if ($menus->isEmpty()) {
                            $enabled = ['members', 'donors', 'events', 'notices', 'sponsors', 'gallery'];
                            if (isset($activeOrg) && isset($activeOrg->menuConfig)) {
                                $enabled = $activeOrg->menuConfig->enabled_menus ?? $enabled;
                            } elseif (isset($activeOrg) && isset($activeOrg->enabled_menus)) {
                                $enabled = $activeOrg->enabled_menus;
                            }
                            $menus = collect([
                                (object)['title' => 'Home', 'url' => route('home'), 'target' => '_self', 'children' => collect()],
                            ]);
                            if (in_array('members', $enabled)) $menus->push((object)['title' => 'Members', 'url' => route('home.members'), 'target' => '_self', 'children' => collect()]);
                            if (in_array('donors', $enabled)) $menus->push((object)['title' => 'Donors', 'url' => route('home.donors'), 'target' => '_self', 'children' => collect()]);
                            if (in_array('events', $enabled)) $menus->push((object)['title' => 'Events', 'url' => route('home.events'), 'target' => '_self', 'children' => collect()]);
                            if (in_array('announcements', $enabled) || in_array('notices', $enabled)) $menus->push((object)['title' => 'Notices', 'url' => route('home.notices'), 'target' => '_self', 'children' => collect()]);
                            if (in_array('sponsors', $enabled)) $menus->push((object)['title' => 'Sponsors', 'url' => route('home.sponsors'), 'target' => '_self', 'children' => collect()]);
                            if (in_array('gallery', $enabled)) $menus->push((object)['title' => 'Gallery', 'url' => route('home.gallery'), 'target' => '_self', 'children' => collect()]);
                        }
                        $portalMenus = $menus;
                    @endphp

                    @foreach($portalMenus as $menu)
                        @if(count($menu->children) > 0)
                            <div class="nav-item-dropdown">
                                <a href="{{ url($menu->url) }}" target="{{ $menu->target }}" class="px-3 py-2 text-sm font-bold transition-colors flex items-center gap-1"
                                    style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                                    onmouseover="this.style.color='var(--color-primary)'"
                                    onmouseout="this.style.color='var(--text-secondary)'">
                                    {{ $menu->title }} <i class='bx bx-chevron-down'></i>
                                </a>
                                <div class="nav-dropdown-content shadow-xl">
                                    @foreach($menu->children as $child)
                                        <a href="{{ url($child->url) }}" target="{{ $child->target }}">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ url($menu->url) }}" target="{{ $menu->target }}" class="px-3 py-2 text-sm font-bold transition-colors"
                                style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                                onmouseover="this.style.color='var(--color-primary)'"
                                onmouseout="this.style.color='var(--text-secondary)'">{{ $menu->title }}</a>
                        @endif
                    @endforeach

                    <a href="{{ route('login') }}"
                        class="ml-4 px-6 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:opacity-90"
                        style="background: var(--color-primary); border-radius: var(--border-radius-md);">Login</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-white mr-2"
                        style="background: var(--color-primary); border-radius: var(--border-radius-md);">Login</a>
                    <button id="mobileMenuBtn" class="text-gray-500 hover:text-gray-900 focus:outline-none p-2">
                        <i class='bx bx-menu text-3xl' style="color: var(--text-primary);"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden border-t"
            style="background: var(--navbar-bg); border-color: var(--border-color-light);">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                @foreach($portalMenus as $menu)
                    <a href="{{ url($menu->url) }}" target="{{ $menu->target }}" class="block px-3 py-2 rounded-md text-base font-medium"
                        style="color: var(--text-primary);">{{ $menu->title }}</a>
                    @if(count($menu->children) > 0)
                        <div class="pl-4">
                            @foreach($menu->children as $child)
                                <a href="{{ url($child->url) }}" target="{{ $child->target }}" class="block px-3 py-2 rounded-md text-sm font-medium"
                                    style="color: var(--text-secondary);">-- {{ $child->title }}</a>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow" style="padding-top: var(--navbar-height, 72px);">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-white/80 pt-16 mt-auto" style="background: var(--color-secondary);">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ $theme->logo_light ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}"
                            alt="Logo" class="h-12 bg-white p-2" style="border-radius: var(--border-radius-lg);">
                        <h3 class="text-2xl font-bold text-white">{{ $activeOrg->name ?? 'Businzo RCMS' }}</h3>
                    </div>
                    <p class="text-white/60 leading-relaxed max-w-md">
                        Connecting residents and simplifying community management. Experience the best in residential
                        living with our modern portal.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}"
                                class="hover:text-white transition-colors flex items-center gap-2"><i
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Home</a></li>
                        <li><a href="{{ route('home.events') }}"
                                class="hover:text-white transition-colors flex items-center gap-2"><i
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Events</a>
                        </li>
                        <li><a href="{{ route('home.gallery') }}"
                                class="hover:text-white transition-colors flex items-center gap-2"><i
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Gallery</a>
                        </li>
                        <li><a href="{{ route('login') }}"
                                class="hover:text-white transition-colors flex items-center gap-2"><i
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Resident
                                Login</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Contact Info</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class='bx bx-map text-xl mt-0.5' style="color: var(--color-primary);"></i>
                            <span
                                class="text-white/70">{{ $activeOrg->address ?? '123 Community Lane, Cityville' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-envelope text-xl' style="color: var(--color-primary);"></i>
                            <span
                                class="text-white/70">{{ 'support@' . ($activeOrg->subdomain ?? 'community') . '.com' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-white/50">&copy; {{ date('Y') }} {{ $activeOrg->name ?? 'Businzo RCMS' }}. All
                    rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center transition-colors"
                        style="hover: background: var(--color-primary);"><i class='bx bxl-facebook text-xl'></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center transition-colors"><i
                            class='bx bxl-twitter text-xl'></i></a>
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center transition-colors"><i
                            class='bx bxl-instagram text-xl'></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('mobileMenuBtn');
            const menu = document.getElementById('mobileMenu');

            if (btn && menu) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>

    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6a28fd25135ef41c3064c772/1jqo1pni0';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="{{ asset('js/global-validation.js') }}"></script>
</body>

</html>