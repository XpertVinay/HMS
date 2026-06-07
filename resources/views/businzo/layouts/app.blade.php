<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Software Development Company') | Businzo</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary-bg: #0f172a;
            --secondary-bg: #1e293b;
            --accent-blue: #3b82f6;
            --accent-purple: #8b5cf6;
            --text-main: #f8fafc;
            --text-muted: #cbd5e1;
        }
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
        }
        .glass-nav {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .gradient-text {
            background: linear-gradient(135deg, #60a5fa, #c084fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .btn-gradient {
            background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(139, 92, 246, 0.5);
        }
        /* Dropdown styles */
        .group:hover .dropdown-menu {
            display: block;
        }
    </style>
    @stack('styles')
</head>
<body class="antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="fixed w-full z-50 glass-nav transition-all duration-300 py-4" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('businzo.home') }}" class="text-2xl font-bold font-['Outfit'] tracking-tight flex items-center gap-2">
                        <div class="w-8 h-8 rounded bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">B</div>
                        <span>Businzo</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('businzo.home') }}" class="text-gray-300 hover:text-white transition-colors font-medium text-sm">Home</a>
                    <a href="{{ route('businzo.about') }}" class="text-gray-300 hover:text-white transition-colors font-medium text-sm">About</a>
                    
                    <!-- Services Dropdown -->
                    <div class="relative group py-2">
                        <button class="text-gray-300 hover:text-white transition-colors font-medium text-sm flex items-center gap-1">
                            Services <i class='bx bx-chevron-down text-lg mt-0.5'></i>
                        </button>
                        <div class="dropdown-menu hidden absolute top-full left-0 mt-0 w-56 rounded-xl shadow-xl bg-slate-800 border border-slate-700 overflow-hidden transform opacity-0 group-hover:opacity-100 transition-all duration-300 origin-top">
                            <div class="py-2">
                                <a href="{{ route('businzo.services') }}#web" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">Web Application</a>
                                <a href="{{ route('businzo.services') }}#mobile" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">Mobile Application</a>
                                <a href="{{ route('businzo.services') }}#ai" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">AI App (RAG, OpenAI)</a>
                                <a href="{{ route('businzo.services') }}#ecommerce" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">eCommerce Solutions</a>
                                <a href="{{ route('businzo.services') }}#custom" class="block px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">Custom Software</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('businzo.contact') }}" class="text-gray-300 hover:text-white transition-colors font-medium text-sm">Contact Us</a>
                    <a href="{{ route('businzo.estimate') }}" class="btn-gradient px-6 py-2.5 rounded-full text-white font-semibold text-sm shadow-lg">Get Estimate</a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class="text-gray-300 hover:text-white focus:outline-none p-2">
                        <i class='bx bx-menu text-3xl'></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-slate-900 border-t border-slate-800 mt-4 absolute w-full">
            <div class="px-4 py-3 space-y-3 shadow-lg">
                <a href="{{ route('businzo.home') }}" class="block text-gray-300 hover:text-white font-medium">Home</a>
                <a href="{{ route('businzo.about') }}" class="block text-gray-300 hover:text-white font-medium">About</a>
                <div class="py-1">
                    <span class="block text-gray-500 font-medium text-sm uppercase tracking-wider mb-2">Services</span>
                    <a href="{{ route('businzo.services') }}#web" class="block pl-4 py-1 text-gray-300 hover:text-white">Web Application</a>
                    <a href="{{ route('businzo.services') }}#mobile" class="block pl-4 py-1 text-gray-300 hover:text-white">Mobile Application</a>
                    <a href="{{ route('businzo.services') }}#ai" class="block pl-4 py-1 text-gray-300 hover:text-white">AI App (RAG, OpenAI)</a>
                    <a href="{{ route('businzo.services') }}#ecommerce" class="block pl-4 py-1 text-gray-300 hover:text-white">eCommerce Solutions</a>
                    <a href="{{ route('businzo.services') }}#custom" class="block pl-4 py-1 text-gray-300 hover:text-white">Custom Software</a>
                </div>
                <a href="{{ route('businzo.contact') }}" class="block text-gray-300 hover:text-white font-medium">Contact Us</a>
                <a href="{{ route('businzo.estimate') }}" class="block w-full text-center btn-gradient px-4 py-2 rounded text-white font-medium mt-4">Get Estimate</a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow pt-20">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 border-t border-slate-800 pt-16 pb-8 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="col-span-1 md:col-span-1">
                    <a href="{{ route('businzo.home') }}" class="text-2xl font-bold font-['Outfit'] tracking-tight flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 rounded bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">B</div>
                        <span>Businzo</span>
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6">
                        Empowering businesses with cutting-edge software solutions, AI integrations, and digital transformation strategies.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-blue-600 hover:text-white transition-colors"><i class='bx bxl-linkedin text-xl'></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-blue-400 hover:text-white transition-colors"><i class='bx bxl-twitter text-xl'></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-gray-400 hover:bg-pink-600 hover:text-white transition-colors"><i class='bx bxl-instagram text-xl'></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-5 font-['Outfit']">Services</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('businzo.services') }}#web" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">Web Development</a></li>
                        <li><a href="{{ route('businzo.services') }}#mobile" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">Mobile Applications</a></li>
                        <li><a href="{{ route('businzo.services') }}#ai" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">AI & Machine Learning</a></li>
                        <li><a href="{{ route('businzo.services') }}#ecommerce" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">eCommerce Solutions</a></li>
                        <li><a href="{{ route('businzo.services') }}#custom" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">Custom Software</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-5 font-['Outfit']">Company</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('businzo.about') }}" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">Careers</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-blue-400 text-sm transition-colors">Terms of Service</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-5 font-['Outfit']">Contact</h4>
                    <ul class="space-y-4 text-sm text-gray-400">
                        <li class="flex items-start gap-3">
                            <i class='bx bx-map text-lg text-blue-500 mt-0.5'></i>
                            <span>123 Innovation Drive,<br>Tech District, TD 12345</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-envelope text-lg text-blue-500'></i>
                            <a href="mailto:hello@businzo.com" class="hover:text-blue-400 transition-colors">hello@businzo.com</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class='bx bx-phone text-lg text-blue-500'></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-gray-500">&copy; {{ date('Y') }} Businzo Software Solutions. All rights reserved.</p>
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
                    menu.classList.toggle('hidden');
                });
            }

            // Navbar scroll effect
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 20) {
                    navbar.classList.add('shadow-lg');
                    navbar.style.background = 'rgba(15, 23, 42, 0.95)';
                } else {
                    navbar.classList.remove('shadow-lg');
                    navbar.style.background = 'rgba(15, 23, 42, 0.7)';
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
