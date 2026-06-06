@extends('layouts.public')
@section('title', 'Gallery')
@section('content')
<div class="container mx-auto px-4 max-w-7xl py-12">
    <div class="text-center mb-16">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">Photo Gallery</h1>
        <p class="text-lg text-gray-600">Memories from our community</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($gallery as $photo)
        <div class="relative group rounded-2xl overflow-hidden aspect-square bg-gray-100 shadow-sm border border-gray-200">
            <img src="{{ Storage::url($photo->image_path) }}" alt="{{ $photo->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-5">
                <h3 class="text-white font-bold text-lg leading-tight">{{ $photo->title }}</h3>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-100 border-dashed">
            <i class='bx bx-images text-5xl text-gray-300 mb-4'></i>
            <p class="text-gray-500 text-lg">No photos in the gallery yet.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
