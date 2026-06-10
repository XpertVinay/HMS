@extends('layouts.public')

@section('title', 'Register RWA')

@section('content')
<div class="relative pt-20 pb-32 flex content-center items-center justify-center min-h-[85vh] -mt-[72px]">
    <!-- Background Image & Overlay -->
    <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop');">
        <span id="blackOverlay" class="w-full h-full absolute opacity-80 bg-gradient-to-r from-[var(--secondary)] to-[var(--primary)]/90 mix-blend-multiply"></span>
    </div>
    
    <div class="container relative mx-auto px-4 z-10 flex justify-center mt-12 mb-12">
        <div class="glass-card rounded-[24px] p-6 sm:p-8 md:p-10 w-full max-w-2xl relative overflow-hidden">
            <!-- Decorative glass shine -->
            <div class="absolute top-0 inset-x-0 h-px bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>
            
            <div class="text-center mb-8 relative">
                <div class="inline-block bg-white/95 p-3 rounded-2xl shadow-[0_0_20px_rgba(255,255,255,0.1)] backdrop-blur-md mb-4 border border-white/20">
                    <img src="{{ $activeOrg->resolved_logo ?? '/assets/images/businzo_logo.png' }}" alt="Logo" class="h-12 w-auto object-contain">
                </div>
                <p class="text-[var(--primary)] text-sm font-semibold tracking-wide drop-shadow-sm uppercase bg-white/90 inline-block px-3 py-1 rounded-full mb-2">Join Us</p>
                <h2 class="text-2xl font-bold text-white mt-1">Register your RWA</h2>
            </div>

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm mb-6 backdrop-blur-sm">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <h3 class="text-sm font-bold text-white/90 uppercase tracking-wider mb-4 pb-2 border-b border-white/10 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--primary)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                        Organization Details
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Organization Name</label>
                            <input type="text" name="org_name" placeholder="e.g. Sunrise Apartments" class="glass-input" required value="{{ old('org_name') }}">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Registration Code</label>
                            <input type="text" name="registration_code" placeholder="e.g. REG-1234" class="glass-input" required value="{{ old('registration_code') }}">
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-xs font-semibold text-white/70 ml-1">Address</label>
                            <input type="text" name="org_address" placeholder="Full Address" class="glass-input" required value="{{ old('org_address') }}">
                        </div>
                        <div class="space-y-1 md:col-span-2">
                            <label class="text-xs font-semibold text-white/70 ml-1">Subdomain</label>
                            <div class="flex items-stretch">
                                <input type="text" name="subdomain" placeholder="myorg" class="glass-input rounded-r-none border-r-0 flex-1 min-w-0" required value="{{ old('subdomain') }}">
                                <span class="bg-white/10 border border-white/20 border-l-0 px-3 sm:px-4 py-3 rounded-r-xl text-white/50 text-xs sm:text-sm flex items-center shrink-0">.businzo.com</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-white/90 uppercase tracking-wider mb-4 pb-2 border-b border-white/10 mt-6 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--primary)]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Admin Account
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Admin First Name</label>
                            <input type="text" name="admin_first_name" placeholder="First name" class="glass-input" value="{{ old('admin_first_name') }}" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Admin Last Name</label>
                            <input type="text" name="admin_last_name" placeholder="Last name" class="glass-input" value="{{ old('admin_last_name') }}" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Admin Username</label>
                            <input type="text" name="admin_username" placeholder="Username" class="glass-input" required value="{{ old('admin_username') }}">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Admin Email</label>
                            <input type="email" name="admin_email" placeholder="admin@example.com" class="glass-input" required value="{{ old('admin_email') }}">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Password</label>
                            <input type="password" name="admin_password" placeholder="••••••••" class="glass-input" required>
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-semibold text-white/70 ml-1">Confirm Password</label>
                            <input type="password" name="admin_password_confirmation" placeholder="••••••••" class="glass-input" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="glass-btn mt-8 flex justify-center items-center gap-2 group">
                    <span>Register Organization</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </button>
                
                <div class="pt-6 mt-6 border-t border-white/10 text-center">
                    <a href="{{ route('login') }}" class="text-white/60 hover:text-white transition-colors flex items-center justify-center gap-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        Already registered? Login here
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Curved Bottom -->
    <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-16" style="transform: translateZ(0);">
        <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
            <polygon class="text-gray-50 fill-current" points="2560 0 2560 100 0 100"></polygon>
        </svg>
    </div>
</div>
@endsection
