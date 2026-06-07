<!DOCTYPE html>
<html lang="en" class="scroll-smooth" data-theme="{{ $themeMode ?? 'light' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') | {{ $activeOrg->name ?? 'Businzo RCMS' }}</title>
    <link rel="shortcut icon" href="{{ $theme->favicon ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    @include('partials.theme-variables')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <img src="{{ $theme->logo_light ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo"
                        class="h-10 w-auto object-contain" style="height: 70px;">
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Home</a>
                    <a href="{{ route('home.members') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Members</a>
                    <a href="{{ route('home.donors') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Donors</a>
                    <a href="{{ route('home.events') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Events</a>
                    <a href="{{ route('home.notices') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Notices</a>
                    <a href="{{ route('home.sponsors') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Sponsors</a>
                    <a href="{{ route('home.gallery') }}"
                        class="px-3 py-2 text-sm font-bold transition-colors"
                        style="color: var(--text-secondary); border-radius: var(--border-radius-sm);"
                        onmouseover="this.style.color='var(--color-primary)'"
                        onmouseout="this.style.color='var(--text-secondary)'"
                        >Gallery</a>

                    <a href="{{ route('login') }}"
                        class="ml-4 px-6 py-2.5 text-sm font-bold text-white shadow-md transition-all hover:opacity-90"
                        style="background: var(--color-primary); border-radius: var(--border-radius-md);"
                        >Login</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-semibold text-white mr-2"
                        style="background: var(--color-primary); border-radius: var(--border-radius-md);"
                        >Login</a>
                    <button id="mobileMenuBtn" class="text-gray-500 hover:text-gray-900 focus:outline-none p-2">
                        <i class='bx bx-menu text-3xl' style="color: var(--text-primary);"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobileMenu" class="hidden md:hidden border-t" style="background: var(--navbar-bg); border-color: var(--border-color-light);">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Home</a>
                <a href="{{ route('home.members') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Members</a>
                <a href="{{ route('home.donors') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Donors</a>
                <a href="{{ route('home.events') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Events</a>
                <a href="{{ route('home.notices') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Notices</a>
                <a href="{{ route('home.sponsors') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Sponsors</a>
                <a href="{{ route('home.gallery') }}" class="block px-3 py-2 rounded-md text-base font-medium" style="color: var(--text-primary);">Gallery</a>
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
                        <img src="{{ $theme->logo_light ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo"
                            class="h-12 bg-white p-2" style="border-radius: var(--border-radius-lg);">
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
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Events</a></li>
                        <li><a href="{{ route('home.gallery') }}"
                                class="hover:text-white transition-colors flex items-center gap-2"><i
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Gallery</a></li>
                        <li><a href="{{ route('login') }}"
                                class="hover:text-white transition-colors flex items-center gap-2"><i
                                    class='bx bx-chevron-right' style="color: var(--color-primary);"></i> Resident Login</a></li>
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
                        style="hover: background: var(--color-primary);"><i
                            class='bx bxl-facebook text-xl'></i></a>
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
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('mobileMenuBtn');
            const menu = document.getElementById('mobileMenu');

            if (btn && menu) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>

</html>