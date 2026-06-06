@extends('layouts.public')
@section('title', 'Donors')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Our Generous Donors</h1>
        <p class="text-lg text-gray-600">Thank you for supporting our community</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($donors as $donor)
        <div class="bg-white hover:bg-gray-50 transition-colors shadow-sm border border-gray-100 rounded-2xl p-6 flex items-center gap-5 hover:shadow-md">
            <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[var(--primary)] to-purple-500 flex items-center justify-center text-white font-bold text-2xl shrink-0 shadow-inner">
                {{ substr($donor->name, 0, 1) }}
            </div>
            <div class="flex-grow overflow-hidden">
                <h3 class="text-lg font-bold text-gray-900 truncate">{{ $donor->name }}</h3>
                <p class="text-[var(--primary)] font-semibold mt-1">₹{{ number_format($donor->amount, 2) }}</p>
            </div>
            <div class="text-right shrink-0">
                <span class="text-xs text-gray-400 block">{{ $donor->created_at?->format('M d, Y') }}</span>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-heart text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No donors listed yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
