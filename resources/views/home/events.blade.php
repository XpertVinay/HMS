@extends('layouts.public')
@section('title', 'Events')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Community Events</h1>
        <p class="text-lg text-gray-600">Join us and be part of our upcoming activities</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($events as $event)
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
        @empty
        <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-calendar-x text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No events scheduled at the moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
