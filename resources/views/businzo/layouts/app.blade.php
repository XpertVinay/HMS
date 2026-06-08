<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Businzo Technologies | Web, Mobile & AI Software Engineering')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        white: '#d1d1d1',
                        background: '#0b0f24',
                        surface: '#161e43',
                        border: 'rgba(255, 255, 255, 0.1)',
                        primary: '#1b449b',
                        accent: '#d51c27',
                        cyan: '#00dfd8',
                        purple: '#7928ca',
                    }
                }
            }
        }
    </script>
    
    <style>
        :root {
            --bg-base: #0b0f24;
            --bg-surface: #161e43;
            --bg-surface-light: #1f2a5c;
            --accent-primary: #1b449b;
            --accent-red: #d51c27;
            --text-main: #d1d1d1;
            --text-muted: #888888;
            --border-color: rgba(255, 255, 255, 0.1);
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-base);
            color: var(--text-main);
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            letter-spacing: -0.02em;
        }
        .glass-nav {
            background: rgba(5, 5, 5, 0.6);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--border-color);
        }
        .glass-panel {
            background: rgba(17, 17, 17, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        }
        .gradient-text {
            background: linear-gradient(to right, #d1d1d1, #888888);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-text-accent {
            background: linear-gradient(135deg, var(--accent-red), var(--accent-primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-premium {
            background: #d1d1d1;
            color: #000000;
            transition: all 0.2s ease;
        }
        .btn-premium:hover {
            background: #e0e0e0;
            transform: translateY(-1px);
        }
        .btn-outline {
            background: transparent;
            border: 1px solid var(--border-color);
            color: #d1d1d1;
            transition: all 0.2s ease;
        }
        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.3);
        }
        .group:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        .dropdown-menu {
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen selection:bg-blue-500/30">

    <!-- Navigation -->
    <nav class="fixed w-full z-[100] glass-nav transition-all duration-300 py-4" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('businzo.home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/businzo/logo.png') }}" alt="Businzo Technologies Logo" class="h-12 w-auto rounded-xl shadow-lg border border-white/10">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('businzo.home') }}" class="text-gray-400 hover:text-white transition-colors font-medium text-sm">Home</a>
                    <a href="{{ route('businzo.about') }}" class="text-gray-400 hover:text-white transition-colors font-medium text-sm">Company</a>
                    <a href="{{ route('businzo.portfolio') }}" class="text-gray-400 hover:text-white transition-colors font-medium text-sm">Work</a>
                    
                    <!-- Services Dropdown -->
                    <div class="relative group py-2">
                        <button class="text-gray-400 hover:text-white transition-colors font-medium text-sm flex items-center gap-1">
                            Expertise <i class='bx bx-chevron-down text-lg mt-0.5 transition-transform group-hover:-rotate-180'></i>
                        </button>
                        <div class="dropdown-menu absolute top-full left-1/2 -translate-x-1/2 mt-2 w-[280px] rounded-xl glass-panel p-2">
                            <a href="{{ route('businzo.services') }}#web" class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i class='bx bx-desktop text-xl text-primary group-hover/item:text-blue-400'></i>
                                <div>
                                    <div class="text-sm font-bold text-white mb-0.5">Web Architecture</div>
                                    <div class="text-xs text-gray-500">Multi-tenant SaaS & enterprise portals</div>
                                </div>
                            </a>
                            <a href="{{ route('businzo.services') }}#mobile" class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i class='bx bx-mobile-alt text-xl text-accent group-hover/item:text-red-400'></i>
                                <div>
                                    <div class="text-sm font-bold text-white mb-0.5">Mobile Engineering</div>
                                    <div class="text-xs text-gray-500">JWT APIs, iOS & Android apps</div>
                                </div>
                            </a>
                            <a href="{{ route('businzo.services') }}#ai" class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i class='bx bx-brain text-xl text-blue-400 group-hover/item:text-blue-300'></i>
                                <div>
                                    <div class="text-sm font-bold text-white mb-0.5">AI & Data</div>
                                    <div class="text-xs text-gray-500">Smart workflows, RAG & automation</div>
                                </div>
                            </a>
                            <a href="{{ route('businzo.services') }}#custom" class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i class='bx bx-code-alt text-xl text-red-400 group-hover/item:text-red-300'></i>
                                <div>
                                    <div class="text-sm font-bold text-white mb-0.5">Custom Software</div>
                                    <div class="text-xs text-gray-500">Domain-specific platforms like RCMS</div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('businzo.contact') }}" class="text-gray-400 hover:text-white transition-colors font-medium text-sm">Contact</a>
                    
                    <div class="h-4 w-px bg-white/10 mx-2"></div>
                    
                    <a href="{{ route('businzo.estimate') }}" class="btn-premium px-5 py-2 rounded-full font-semibold text-sm">
                        Get Estimate
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-400 hover:text-white focus:outline-none p-2">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-background border-b border-white/10 absolute w-full left-0 top-full shadow-2xl">
            <div class="px-6 py-6 space-y-4">
                <a href="{{ route('businzo.home') }}" class="block text-xl text-gray-300 hover:text-white font-medium">Home</a>
                <a href="{{ route('businzo.about') }}" class="block text-xl text-gray-300 hover:text-white font-medium">Company</a>
                <a href="{{ route('businzo.portfolio') }}" class="block text-xl text-gray-300 hover:text-white font-medium">Work</a>
                <div class="py-2 border-y border-white/5">
                    <span class="block text-xs text-gray-500 uppercase tracking-widest font-bold mb-3">Expertise</span>
                    <a href="{{ route('businzo.services') }}#web" class="block py-2 text-gray-300 hover:text-white">Web Architecture</a>
                    <a href="{{ route('businzo.services') }}#mobile" class="block py-2 text-gray-300 hover:text-white">Mobile Engineering</a>
                    <a href="{{ route('businzo.services') }}#ai" class="block py-2 text-gray-300 hover:text-white">AI & Data Models</a>
                    <a href="{{ route('businzo.services') }}#custom" class="block py-2 text-gray-300 hover:text-white">Custom Software</a>
                </div>
                <a href="{{ route('businzo.contact') }}" class="block text-xl text-gray-300 hover:text-white font-medium">Contact</a>
                <a href="{{ route('businzo.estimate') }}" class="block w-full text-center btn-premium px-4 py-3 rounded-lg text-black font-bold mt-4">Get Estimate</a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow pt-[80px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 pt-20 pb-10 bg-background relative overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-16">
                <div class="lg:col-span-2">
                    <a href="{{ route('businzo.home') }}" class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('assets/images/businzo/logo.png') }}" alt="Businzo Technologies Logo" class="h-16 w-auto rounded-2xl shadow-xl border border-white/10">
                    </a>
                    <p class="text-gray-500 text-sm leading-relaxed mb-8 max-w-sm">
                        We build production-grade software — web platforms, mobile applications, AI/ML engineering, and custom systems. From discovery to deployment, we ship secure, scalable products that teams rely on.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://in.linkedin.com/company/businzotech" class="text-gray-500 hover:text-white transition-colors"><i class='bx bxl-linkedin text-2xl'></i></a>
                        <a href="https://x.com/businzotech" class="text-gray-500 hover:text-white transition-colors"><i class='bx bxl-twitter text-2xl'></i></a>
                        <a href="https://www.facebook.com/BusinzoTechnologies" class="text-gray-500 hover:text-white transition-colors"><i class='bx bxl-facebook text-2xl'></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-6 font-['Outfit']">Engineering</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('businzo.services') }}#web" class="text-gray-500 hover:text-white text-sm transition-colors">Web Apps</a></li>
                        <li><a href="{{ route('businzo.services') }}#mobile" class="text-gray-500 hover:text-white text-sm transition-colors">Mobile OS</a></li>
                        <li><a href="{{ route('businzo.services') }}#ai" class="text-gray-500 hover:text-white text-sm transition-colors">Machine Learning</a></li>
                        <li><a href="{{ route('businzo.services') }}#custom" class="text-gray-500 hover:text-white text-sm transition-colors">System Arch</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-6 font-['Outfit']">Company</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('businzo.about') }}" class="text-gray-500 hover:text-white text-sm transition-colors">About Us</a></li>
                        <li><a href="{{ route('businzo.careers') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-500 hover:text-white text-sm transition-colors">Blog</a></li>
                        <li><a href="{{ route('businzo.contact') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-6 font-['Outfit']">Legal</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('businzo.privacy') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('businzo.terms') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-600">&copy; {{ date('Y') }} Businzo Technologies. All rights reserved.</p>
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <span>Status:</span> <span class="flex items-center gap-1.5"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> All systems operational</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu Toggle
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            
            if (btn && menu) {
                btn.addEventListener('click', () => {
                    if (menu.classList.contains('hidden')) {
                        menu.classList.remove('hidden');
                        btn.innerHTML = "<i class='bx bx-x text-2xl'></i>";
                    } else {
                        menu.classList.add('hidden');
                        btn.innerHTML = "<i class='bx bx-menu text-2xl'></i>";
                    }
                });
            }

            // Navbar scroll effect
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.style.background = 'rgba(5, 5, 5, 0.8)';
                } else {
                    navbar.style.background = 'rgba(5, 5, 5, 0.6)';
                }
            });
        });
    </script>
    
    <!-- AOS Animation JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            easing: 'ease-out-cubic',
        });
    </script>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    
    @stack('scripts')
</body>
</html>
