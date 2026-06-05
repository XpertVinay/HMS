@extends('layouts.public')
@section('title', 'Sponsors')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Our Sponsors</h1>
        <p class="text-lg text-gray-600">The brands that help make our community great</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($sponsors as $sponsor)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-all duration-300 p-6 flex flex-col items-center text-center group">
            @if($sponsor->logo)
            <img src="{{ Storage::url($sponsor->logo) }}" alt="{{ $sponsor->name }}" class="h-20 w-auto mb-4 object-contain group-hover:scale-105 transition-transform">
            @else
            <div class="w-20 h-20 mb-4 rounded-xl bg-gray-50 border border-gray-100 flex items-center justify-center text-gray-300 group-hover:scale-105 transition-transform">
                <i class='bx bx-store-alt text-3xl'></i>
            </div>
            @endif
            <h3 class="text-lg font-bold text-gray-900">{{ $sponsor->name }}</h3>
            @if($sponsor->website)
            <a href="{{ $sponsor->website }}" target="_blank" class="text-[var(--primary)] text-sm mt-2 font-medium hover:underline inline-flex items-center gap-1">
                Visit Website <i class='bx bx-link-external'></i>
            </a>
            @endif
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-building-house text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No sponsors listed yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
