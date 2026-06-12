<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Businzo Technologies | AI-Powered Software Engineering')</title>

    @vite(['resources/css/businzo.css'])

    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- AOS Animation CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @stack('styles')
</head>

<body class="flex flex-col min-h-screen selection:bg-primary/30">

    <!-- Navigation -->
    <nav class="fixed w-full z-[100] glass-nav transition-all duration-300 py-4" id="navbar">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('businzo.home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/businzo/logo.png') }}" alt="Businzo Technologies Logo"
                            class="h-12 w-auto rounded-xl shadow-lg border border-white/10 bg-white/80">
                        <h2 class="text-2xl font-bold">Businzo Technologies</h2>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('businzo.home') }}"
                        class=" hover:text-foreground transition-colors font-medium text-sm">Home</a>
                    <a href="{{ route('businzo.about') }}"
                        class=" hover:text-foreground transition-colors font-medium text-sm">Company</a>
                    <a href="{{ route('businzo.portfolio') }}"
                        class=" hover:text-foreground transition-colors font-medium text-sm">Work</a>

                    <!-- Services Dropdown -->
                    <div class="relative group py-2">
                        <button
                            class=" hover:text-foreground transition-colors font-medium text-sm flex items-center gap-1">
                            Expertise <i
                                class='bx bx-chevron-down text-lg mt-0.5 transition-transform group-hover:-rotate-180'></i>
                        </button>
                        <div
                            class="dropdown-menu absolute top-full left-1/2 -translate-x-1/2 mt-2 w-[280px] rounded-xl glass-panel p-2">
                            <a href="{{ route('businzo.services') }}#web"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i class='bx bx-desktop text-xl text-primary group-hover/item:text-primary-light'></i>
                                <div>
                                    <div class="text-sm font-bold text-foreground mb-0.5">Web Platforms</div>
                                    <div class="text-xs text-muted">Scalable SaaS & enterprise portals that grow with
                                        you</div>
                                </div>
                            </a>
                            <a href="{{ route('businzo.services') }}#mobile"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i
                                    class='bx bx-mobile-alt text-xl gradient-text-accent group-hover/item:text-accent-light'></i>
                                <div>
                                    <div class="text-sm font-bold text-foreground mb-0.5">Mobile Products</div>
                                    <div class="text-xs text-muted">Secure, native apps that drive user engagement</div>
                                </div>
                            </a>
                            <a href="{{ route('businzo.services') }}#ai"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i
                                    class='bx bx-brain text-xl text-primary-light group-hover/item:text-primary-light'></i>
                                <div>
                                    <div class="text-sm font-bold text-foreground mb-0.5">AI & Automation</div>
                                    <div class="text-xs text-muted">MCP integrations, agents & intelligent workflows
                                    </div>
                                </div>
                            </a>
                            <a href="{{ route('businzo.services') }}#custom"
                                class="flex items-start gap-3 p-3 rounded-lg hover:bg-white/5 transition-colors group/item">
                                <i
                                    class='bx bx-code-alt text-xl gradient-text-accent group-hover/item:text-accent-light'></i>
                                <div>
                                    <div class="text-sm font-bold text-foreground mb-0.5">Custom Software</div>
                                    <div class="text-xs text-muted">Domain-specific platforms built for your market
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <a href="{{ route('businzo.contact') }}"
                        class=" hover:text-foreground transition-colors font-medium text-sm">Contact</a>

                    <div class="h-4 w-px bg-white/10 mx-2"></div>

                    <a href="{{ route('businzo.contact') }}"
                        class="btn-outline px-4 py-2 rounded-full font-semibold text-sm hidden lg:inline-flex">
                        Book a Consultation
                    </a>
                    <a href="{{ route('businzo.estimate') }}"
                        class="btn-premium px-5 py-2 rounded-full font-semibold text-sm">
                        Start Your Project
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn" class=" hover:text-foreground focus:outline-none p-2">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu"
            class="hidden md:hidden bg-background border-b border-white/10 absolute w-full left-0 top-full shadow-2xl">
            <div class="px-6 py-6 space-y-4">
                <a href="{{ route('businzo.home') }}" class="block text-xl  hover:text-foreground font-medium">Home</a>
                <a href="{{ route('businzo.about') }}"
                    class="block text-xl  hover:text-foreground font-medium">Company</a>
                <a href="{{ route('businzo.portfolio') }}"
                    class="block text-xl  hover:text-foreground font-medium">Work</a>
                <div class="py-2 border-y border-white/5">
                    <span class="block text-xs text-subtle uppercase tracking-widest font-bold mb-3">Expertise</span>
                    <a href="{{ route('businzo.services') }}#web" class="block py-2  hover:text-foreground">Web
                        Architecture</a>
                    <a href="{{ route('businzo.services') }}#mobile" class="block py-2  hover:text-foreground">Mobile
                        Engineering</a>
                    <a href="{{ route('businzo.services') }}#ai" class="block py-2  hover:text-foreground">AI & MCP
                        Integrations</a>
                    <a href="{{ route('businzo.services') }}#custom" class="block py-2  hover:text-foreground">Custom
                        Software</a>
                </div>
                <a href="{{ route('businzo.contact') }}"
                    class="block text-xl  hover:text-foreground font-medium">Contact</a>
                <a href="{{ route('businzo.contact') }}"
                    class="block w-full text-center btn-outline px-4 py-3 rounded-lg font-bold mt-4">Book a
                    Consultation</a>
                <a href="{{ route('businzo.estimate') }}"
                    class="block w-full text-center btn-premium px-4 py-3 rounded-lg font-bold mt-3">Start Your
                    Project</a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow pt-[80px]">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-white/10 pt-20 pb-10 bg-background relative overflow-hidden">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-px bg-gradient-to-r from-transparent via-primary to-transparent opacity-50">
        </div>
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-16">
                <div class="lg:col-span-2">
                    <a href="{{ route('businzo.home') }}" class="flex items-center gap-2 mb-6">
                        <img src="{{ asset('assets/images/businzo/logo.png') }}" alt="Businzo Technologies Logo"
                            class="h-16 w-auto rounded-2xl shadow-xl border border-white/10 bg-white/80">
                        <h2 class="text-2xl font-bold">Businzo Technologies</h2>
                    </a>
                    <p class="text-sm leading-relaxed mb-8 max-w-sm text-muted">
                        We engineer AI-powered, production-ready software — web platforms, mobile apps, MCP
                        integrations, and intelligent automation. Secure, scalable systems built to accelerate your
                        business growth.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://in.linkedin.com/company/businzotech"
                            class=" hover:text-foreground transition-colors"><i
                                class='bx bxl-linkedin text-2xl'></i></a>
                        <a href="https://x.com/businzotech" class=" hover:text-foreground transition-colors"><i
                                class='bx bxl-twitter text-2xl'></i></a>
                        <a href="https://www.facebook.com/BusinzoTechnologies"
                            class=" hover:text-foreground transition-colors"><i
                                class='bx bxl-facebook text-2xl'></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="text-foreground font-semibold mb-6 font-['Outfit']">Expertise</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('businzo.services') }}#web"
                                class="text-muted hover:text-foreground text-sm transition-colors">Web Platforms</a>
                        </li>
                        <li><a href="{{ route('businzo.services') }}#mobile"
                                class="text-muted hover:text-foreground text-sm transition-colors">Mobile Products</a>
                        </li>
                        <li><a href="{{ route('businzo.services') }}#ai"
                                class="text-muted hover:text-foreground text-sm transition-colors">AI & MCP
                                Integrations</a></li>
                        <li><a href="{{ route('businzo.services') }}#custom"
                                class="text-muted hover:text-foreground text-sm transition-colors">Custom Software</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-foreground font-semibold mb-6 font-['Outfit']">Company</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('businzo.about') }}"
                                class=" hover:text-foreground text-sm transition-colors">About Us</a></li>
                        <li><a href="{{ route('businzo.careers') }}"
                                class=" hover:text-foreground text-sm transition-colors">Careers</a></li>
                        <li><a href="#" class=" hover:text-foreground text-sm transition-colors">Blog</a></li>
                        <li><a href="{{ route('businzo.contact') }}"
                                class=" hover:text-foreground text-sm transition-colors">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-foreground font-semibold mb-6 font-['Outfit']">Legal</h4>
                    <ul class="space-y-4">
                        <li><a href="{{ route('businzo.privacy') }}"
                                class=" hover:text-foreground text-sm transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('businzo.terms') }}"
                                class=" hover:text-foreground text-sm transition-colors">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-sm text-subtle">&copy; {{ date('Y') }} Businzo Technologies. All rights reserved.</p>
                <div class="flex items-center gap-2 text-sm text-subtle">
                    <span>Status:</span> <span class="flex items-center gap-1.5"><span
                            class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> All systems
                        operational</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
                    navbar.style.background = 'rgba(11, 15, 36, 0.92)';
                } else {
                    navbar.style.background = 'rgba(11, 15, 36, 0.75)';
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

    @stack('scripts')
</body>

</html>