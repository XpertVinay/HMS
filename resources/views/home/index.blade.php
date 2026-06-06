@extends('layouts.public')

@section('title', 'Community Portal')

@section('content')
    <!-- Hero Section -->
    <div class="relative pt-20 pb-32 flex content-center items-center justify-center min-h-[85vh] -mt-[72px]">
        <!-- Background Image & Overlay -->
        <div class="absolute top-0 w-full h-full bg-center bg-cover" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop');">
            <span id="blackOverlay" class="w-full h-full absolute opacity-80 bg-gradient-to-r from-[var(--secondary)] to-[var(--primary)]/90 mix-blend-multiply"></span>
        </div>
        
        <div class="container relative mx-auto px-4">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-8/12 md:w-10/12 ml-auto mr-auto text-center">
                    <div class="px-4 animate-fade-in-up">
                        <span class="text-white/80 font-semibold tracking-wider uppercase text-sm mb-4 block">Welcome to our community</span>
                        <h1 class="text-white font-extrabold text-4xl sm:text-5xl md:text-6xl tracking-tight leading-tight mb-6">
                            Experience Modern <br class="hidden sm:block"/> Community Living
                        </h1>
                        <p class="mt-4 text-lg text-white/90 leading-relaxed max-w-2xl mx-auto">
                            A fully integrated digital platform to connect residents, streamline management, and build a thriving, secure, and harmonious neighborhood.
                        </p>
                        
                        <div class="mt-10 flex flex-wrap justify-center gap-4">
                            <a href="{{ route('login') }}" class="px-8 py-4 rounded-full text-base font-bold text-[var(--primary)] bg-white hover:bg-gray-50 shadow-xl transition-all hover:-translate-y-1">
                                Access Portal
                            </a>
                            <a href="#about" class="px-8 py-4 rounded-full text-base font-bold text-white bg-white/20 hover:bg-white/30 backdrop-blur-sm border border-white/30 shadow-xl transition-all hover:-translate-y-1">
                                Explore More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Curved Bottom -->
        <div class="top-auto bottom-0 left-0 right-0 w-full absolute pointer-events-none overflow-hidden h-16" style="transform: translateZ(0);">
            <svg class="absolute bottom-0 overflow-hidden" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" version="1.1" viewBox="0 0 2560 100" x="0" y="0">
                <polygon class="text-gray-50 fill-current" points="2560 0 2560 100 0 100"></polygon>
            </svg>
        </div>
    </div>

    <!-- Stats Section -->
    <section class="pb-20 bg-gray-50 -mt-16 relative z-10">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Stat 1 -->
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 text-center transform transition duration-500 hover:scale-105 border border-gray-100">
                    <div class="text-[var(--primary)] bg-[var(--primary)]/10 w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4">
                        <i class='bx bx-group text-3xl'></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-gray-900">{{ $members ?? '250+' }}</h3>
                    <p class="text-gray-500 font-medium mt-1">Happy Residents</p>
                </div>
                <!-- Stat 2 -->
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 text-center transform transition duration-500 hover:scale-105 border border-gray-100">
                    <div class="text-[var(--primary)] bg-[var(--primary)]/10 w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4">
                        <i class='bx bx-calendar-star text-3xl'></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-gray-900">{{ count($events ?? []) }}</h3>
                    <p class="text-gray-500 font-medium mt-1">Upcoming Events</p>
                </div>
                <!-- Stat 3 -->
                <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-8 text-center transform transition duration-500 hover:scale-105 border border-gray-100">
                    <div class="text-[var(--primary)] bg-[var(--primary)]/10 w-16 h-16 mx-auto rounded-2xl flex items-center justify-center mb-4">
                        <i class='bx bx-bell text-3xl'></i>
                    </div>
                    <h3 class="text-4xl font-extrabold text-gray-900">{{ count($announcements ?? []) }}</h3>
                    <p class="text-gray-500 font-medium mt-1">Active Notices</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="flex flex-wrap items-center">
                <div class="w-full md:w-5/12 px-4 mr-auto ml-auto mb-12 md:mb-0">
                    <div class="text-gray-500 p-3 text-center inline-flex items-center justify-center w-16 h-16 mb-6 shadow-lg rounded-full bg-[var(--primary)]/10">
                        <i class='bx bx-buildings text-2xl text-[var(--primary)]'></i>
                    </div>
                    <h3 class="text-3xl font-bold leading-tight mb-4 text-gray-900">Elevating Community Standards</h3>
                    <p class="text-lg font-light leading-relaxed mt-4 mb-4 text-gray-600">
                        Our resident portal brings everyone together. From paying maintenance bills seamlessly to booking amenities and raising helpdesk tickets, everything is just a click away.
                    </p>
                    <p class="text-lg font-light leading-relaxed mt-0 mb-8 text-gray-600">
                        Stay informed about what's happening in your neighborhood with real-time notice board updates and community event calendars.
                    </p>
                    <a href="{{ route('home.gallery') }}" class="font-bold text-[var(--primary)] hover:text-[var(--secondary)] transition-colors flex items-center gap-2">
                        View Gallery <i class='bx bx-right-arrow-alt'></i>
                    </a>
                </div>
                <div class="w-full md:w-6/12 px-4 mr-auto ml-auto">
                    <div class="relative flex flex-col min-w-0 break-words w-full shadow-2xl rounded-2xl overflow-hidden bg-[var(--primary)]">
                        <img alt="Community Image" src="https://images.unsplash.com/photo-1574362848149-11496d93a7c7?q=80&w=1984&auto=format&fit=crop" class="w-full align-middle opacity-90">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notices Section -->
    @if(count($announcements ?? []) > 0)
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Latest Notices</h2>
                <p class="text-gray-500 mt-2">Stay updated with important community announcements</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($announcements as $notice)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col h-full group">
                    <div class="h-2 w-full bg-gradient-to-r from-[var(--primary)] to-purple-400"></div>
                    <div class="p-6 flex-grow">
                        <div class="flex items-center text-xs text-gray-500 mb-3 font-medium uppercase tracking-wider">
                            <i class='bx bx-time mr-1'></i>
                            {{ $notice->created_at?->format('M d, Y') }}
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[var(--primary)] transition-colors">{{ $notice->announcement_subject }}</h3>
                        <p class="text-gray-600 line-clamp-3 leading-relaxed">{{ $notice->announcement_text }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('home.notices') }}" class="inline-flex items-center gap-2 font-semibold text-[var(--primary)] hover:text-[var(--secondary)] transition-colors">
                    View All Notices <i class='bx bx-right-arrow-alt'></i>
                </a>
            </div>
        </div>
    </section>
    @endif

    <!-- Events Section -->
    @if(count($events ?? []) > 0)
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Upcoming Events</h2>
                <p class="text-gray-500 mt-2">Join us and celebrate together</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($events as $event)
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    <div class="h-48 overflow-hidden relative">
                        <div class="absolute inset-0 bg-gray-200">
                            <img src="https://images.unsplash.com/photo-1511795409834-ef04bbd61622?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Event">
                        </div>
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-xl p-2 text-center shadow-lg min-w-[60px]">
                            <span class="block text-sm text-[var(--primary)] font-bold uppercase">{{ $event->event_date?->format('M') }}</span>
                            <span class="block text-2xl font-black text-gray-900">{{ $event->event_date?->format('d') }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-[var(--primary)] transition-colors">{{ $event->title }}</h3>
                        <p class="text-gray-600 line-clamp-2 mb-4">{{ $event->description }}</p>
                        @if($event->event_time)
                        <div class="flex items-center text-sm font-medium text-gray-500 bg-gray-50 p-2 rounded-lg inline-flex">
                            <i class='bx bx-time-five text-[var(--primary)] mr-2'></i> {{ $event->event_time }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

@endsection
