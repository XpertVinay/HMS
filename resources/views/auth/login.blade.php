@extends('layouts.public')

@section('title', 'Login')

@section('content')
    <div class="relative pt-20 pb-32 flex content-center items-center justify-center min-h-[85vh] -mt-[72px]">
        <!-- Background Image & Overlay -->
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop');">
            <span id="blackOverlay"
                class="w-full h-full absolute opacity-80 bg-gradient-to-r from-[var(--secondary)] to-[var(--primary)]/90 mix-blend-multiply"></span>
        </div>

        <div class="container relative mx-auto px-4 z-10 flex justify-center">
            <div class="glass-card rounded-[24px] p-6 sm:p-8 md:p-10 w-full max-w-[440px] relative overflow-hidden">
                <!-- Decorative glass shine -->
                <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent">
                </div>

                <div class="text-center mb-8 relative">
                    <div
                        class="inline-block bg-white/95 p-3 rounded-2xl shadow-[0_0_20px_rgba(255,255,255,0.1)] backdrop-blur-md mb-4 border border-white/20">
                        @php
                            $logoUrl = '/assets/images/businzo_logo.png';
                            if (isset($theme)) {
                                // Login page has a light/glass background behind the logo
                                $logoUrl = $theme->logo_light ?? $theme->logo_dark ?? $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png';
                            } elseif (isset($activeOrg)) {
                                $logoUrl = $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png';
                            }

                            $finalLogoSrc = (str_starts_with($logoUrl, 'http') || str_starts_with($logoUrl, '/'))
                                ? $logoUrl
                                : asset('storage/' . $logoUrl);
                        @endphp
                        <img src="{{ $finalLogoSrc }}" alt="Organization Logo" class="h-14 w-auto object-contain">
                    </div>
                    <p class="text-white/70 text-sm font-medium tracking-wide">Welcome to the Community Portal</p>
                    <h2 class="text-2xl font-bold text-white mt-1">Sign In to Your Account</h2>
                </div>

                @if(session('success'))
                    <div
                        class="bg-green-500/10 border border-green-500/30 text-green-400 px-4 py-3 rounded-xl text-sm mb-6 text-center backdrop-blur-sm animate-fade-in">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->has('login'))
                    <div
                        class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm mb-6 text-center backdrop-blur-sm animate-fade-in">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
                    @csrf
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-white/70 uppercase tracking-wider ml-1">Username</label>
                        <div class="relative">
                            <input type="text" name="username" placeholder="Enter your username" class="glass-input !pl-11"
                                required autocomplete="username" value="{{ old('username') }}">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-semibold text-white/70 uppercase tracking-wider ml-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" placeholder="Enter your password"
                                class="glass-input !pl-11" required autocomplete="current-password">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-white/50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="glass-btn mt-6 flex justify-center items-center gap-2 group">
                        <span>Log In</span>
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>

                    <div
                        class="pt-6 mt-6 border-t border-white/10 text-center flex flex-col sm:flex-row justify-center items-center gap-4 text-sm">
                        <a href="{{ route('home') }}"
                            class="text-white/60 hover:text-white transition-colors flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="19" y1="12" x2="5" y2="12"></line>
                                <polyline points="12 19 5 12 12 5"></polyline>
                            </svg>
                            Back To Home
                        </a>
                        <span class="hidden sm:inline text-white/20">|</span>
                        <a href="{{ route('register') }}"
                            class="text-[var(--primary)] hover:text-white transition-colors font-medium drop-shadow-md">
                            Register RWA
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Curved Bottom -->
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-16"
            style="transform: translateZ(0); display: none">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none"
                version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-gray-50 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>
@endsection