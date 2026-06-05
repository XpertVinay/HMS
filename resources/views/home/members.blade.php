@extends('layouts.public')
@section('title', 'Members')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Community Members</h1>
        <p class="text-lg text-gray-600">Meet the wonderful people in our community</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($members as $member)
        <div class="bg-white hover:bg-gray-50 transition-colors shadow-sm border border-gray-100 rounded-2xl p-6 flex items-center gap-5 hover:shadow-md">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[var(--primary)] to-purple-500 flex items-center justify-center text-white font-bold text-2xl shrink-0 shadow-inner">
                {{ strtoupper(substr($member->username, 0, 1)) }}
            </div>
            <div class="flex-grow overflow-hidden">
                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $member->username }}</h3>
                <p class="text-gray-500 text-sm truncate">{{ $member->email }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-group text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No members listed yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
