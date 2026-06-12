@extends('layouts.portal')

@section('title', 'Add Industry')

@section('content')
<div class="content-header mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Add Industry</h2>
    <a href="{{ route('super_admin.industries.index') }}" class="btn btn-secondary">
        <i class='bx bx-arrow-back'></i> Back
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
    <form action="{{ route('super_admin.industries.store') }}" method="POST">
        @csrf
        
        <div class="form-group mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Industry Name <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="form-control w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required placeholder="e.g., Real Estate, RWA">
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="form-group mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Base Platform Fee ($) <span class="text-red-500">*</span></label>
            <input type="number" step="0.01" name="base_fee" class="form-control w-full rounded-lg border-gray-300 dark:border-slate-600 dark:bg-slate-700 @error('base_fee') border-red-500 @enderror" value="{{ old('base_fee', '0.00') }}" required>
            <small class="text-gray-500 block mt-1">This is the base registration fee before any features are added.</small>
            @error('base_fee') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mt-6">
            <button type="submit" class="btn btn-primary px-6 py-2">
                <i class='bx bx-save mr-2'></i> Save Industry
            </button>
        </div>
    </form>
</div>
@endsection
