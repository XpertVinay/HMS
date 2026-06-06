<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Welcome') | {{ $activeOrg->name ?? 'Businzo RCMS' }}</title>
    <link rel="shortcut icon" href="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: {{ $activeOrg->resolved_primary_color ?? '#E6192B' }};
            --secondary: {{ $activeOrg->resolved_secondary_color ?? '#1E2B58' }};
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-50 flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-gray-200 transition-all shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-[72px]">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo" class="h-10 w-auto object-contain" style="height: 70px;">
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Home</a>
                    <a href="{{ route('home.members') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Members</a>
                    <a href="{{ route('home.donors') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Donors</a>
                    <a href="{{ route('home.events') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Events</a>
                    <a href="{{ route('home.notices') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Notices</a>
                    <a href="{{ route('home.sponsors') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Sponsors</a>
                    <a href="{{ route('home.gallery') }}" class="px-3 py-2 rounded-md text-sm font-bold text-gray-700 hover:text-primary hover:bg-gray-50 transition-colors">Gallery</a>
                    
                    <a href="{{ route('login') }}" class="ml-4 px-6 py-2.5 rounded-lg text-sm font-bold text-white bg-primary hover:opacity-90 shadow-md transition-all" style="background: #0d1f3f">Login</a>
                </div>
                
                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg text-sm font-semibold text-white bg-primary mr-2">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow pt-[72px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[var(--secondary)] text-white/80 pt-16 mt-auto">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-3 mb-6">
                        <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo" class="h-12 bg-white p-2 rounded-xl">
                        <h3 class="text-2xl font-bold text-white">{{ $activeOrg->name ?? 'Businzo RCMS' }}</h3>
                    </div>
                    <p class="text-white/60 leading-relaxed max-w-md">
                        Connecting residents and simplifying community management. Experience the best in residential living with our modern portal.
                    </p>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Quick Links</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class='bx bx-chevron-right text-primary'></i> Home</a></li>
                        <li><a href="{{ route('home.events') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class='bx bx-chevron-right text-primary'></i> Events</a></li>
                        <li><a href="{{ route('home.gallery') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class='bx bx-chevron-right text-primary'></i> Gallery</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors flex items-center gap-2"><i class='bx bx-chevron-right text-primary'></i> Resident Login</a></li>
                    </ul>
                </div>
                
                <div>
                    <h4 class="text-white font-bold mb-6 tracking-wider uppercase text-sm">Contact Info</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3">
                            <i class='bx bx-map text-primary text-xl mt-0.5'></i>
                            <span class="text-white/70">{{ $activeOrg->address ?? '123 Community Lane, Cityville' }}</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-envelope text-primary text-xl'></i>
                            <span class="text-white/70">support@{{ $activeOrg->subdomain ?? 'community' }}.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-white/10 py-6 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-white/50">&copy; {{ date('Y') }} {{ $activeOrg->name ?? 'Businzo RCMS' }}. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors"><i class='bx bxl-facebook text-xl'></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors"><i class='bx bxl-twitter text-xl'></i></a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors"><i class='bx bxl-instagram text-xl'></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
