@extends('layouts.public')
@section('title', 'Notices')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Community Notices</h1>
        <p class="text-lg text-gray-600">Important announcements and updates</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($announcements as $notice)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 overflow-hidden flex flex-col h-full relative group">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-[var(--primary)] to-purple-400"></div>
            <div class="p-6 pl-8 flex-grow">
                <div class="flex items-center text-xs text-gray-500 mb-3 font-medium uppercase tracking-wider">
                    <i class='bx bx-time mr-1'></i>
                    {{ $notice->created_at?->format('M d, Y') }}
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-[var(--primary)] transition-colors">{{ $notice->announcement_subject }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ $notice->announcement_text }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-bell-off text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No recent notices available.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
