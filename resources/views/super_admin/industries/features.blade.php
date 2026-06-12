@extends('layouts.portal')

@section('title', 'Manage Features: ' . $industry->name)

@section('content')
<div class="content-header mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Features for: {{ $industry->name }}</h2>
    <a href="{{ route('super_admin.industries.index') }}" class="btn btn-secondary">
        <i class='bx bx-arrow-back'></i> Back
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <!-- Add New Feature -->
    <div class="md:col-span-1">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h4 class="font-bold mb-4">Add New Feature</h4>
            <form action="{{ route('super_admin.industries.features.store', $industry->id) }}" method="POST">
                @csrf
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Feature Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="form-control w-full rounded-lg" required placeholder="e.g., Payment Gateway">
                </div>
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                    <textarea name="description" class="form-control w-full rounded-lg" rows="3" placeholder="Optional description..."></textarea>
                </div>
                <div class="form-group mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Additional Fee ($) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="price" class="form-control w-full rounded-lg" value="0.00" required>
                </div>
                <button type="submit" class="btn btn-primary w-full">Add Feature</button>
            </form>
        </div>
    </div>

    <!-- Features List -->
    <div class="md:col-span-2">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
            <h4 class="font-bold mb-4">Configured Features</h4>
            <div class="overflow-x-auto">
                <table class="table w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-700/50">
                            <th class="p-4 border-b">Feature</th>
                            <th class="p-4 border-b">Description</th>
                            <th class="p-4 border-b">Fee</th>
                            <th class="p-4 border-b text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($features as $feature)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30">
                                <td class="p-4 border-b font-medium">{{ $feature->name }}</td>
                                <td class="p-4 border-b text-sm text-gray-500">{{ Str::limit($feature->description, 50) }}</td>
                                <td class="p-4 border-b text-green-600 font-bold">+${{ number_format($feature->price, 2) }}</td>
                                <td class="p-4 border-b text-right">
                                    <form action="{{ route('super_admin.industries.features.destroy', [$industry->id, $feature->id]) }}" method="POST" onsubmit="return confirm('Remove this feature?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700"><i class='bx bx-trash'></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
