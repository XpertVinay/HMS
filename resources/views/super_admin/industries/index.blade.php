@extends('layouts.portal')

@section('title', 'Industry Configurations')

@section('content')
<div class="content-header mb-4 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Industry Configurations</h2>
    <a href="{{ route('super_admin.industries.create') }}" class="btn btn-primary">
        <i class='bx bx-plus'></i> Add Industry
    </a>
</div>

<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 p-6">
    <div class="overflow-x-auto">
        <table class="table w-full text-left border-collapse data-table">
            <thead>
                <tr class="bg-gray-50 dark:bg-slate-700/50">
                    <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-semibold text-gray-700 dark:text-gray-300">Industry Name</th>
                    <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-semibold text-gray-700 dark:text-gray-300">Base Fee</th>
                    <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-semibold text-gray-700 dark:text-gray-300">Status</th>
                    <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-semibold text-gray-700 dark:text-gray-300">Configurations</th>
                    <th class="p-4 border-b border-gray-200 dark:border-slate-600 font-semibold text-gray-700 dark:text-gray-300 text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($industries as $industry)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="p-4 border-b border-gray-100 dark:border-slate-700 font-medium">
                            {{ $industry->name }}
                        </td>
                        <td class="p-4 border-b border-gray-100 dark:border-slate-700">
                            ${{ number_format($industry->base_fee, 2) }}
                        </td>
                        <td class="p-4 border-b border-gray-100 dark:border-slate-700">
                            @if($industry->is_active)
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="p-4 border-b border-gray-100 dark:border-slate-700">
                            <a href="{{ route('super_admin.industries.features', $industry->id) }}" class="btn btn-sm btn-info mb-1">
                                <i class='bx bx-list-ul'></i> Features ({{ $industry->features_count }})
                            </a>
                            <a href="{{ route('super_admin.industries.role_presets', $industry->id) }}" class="btn btn-sm btn-secondary mb-1">
                                <i class='bx bx-shield'></i> Roles ({{ $industry->role_presets_count }})
                            </a>
                        </td>
                        <td class="p-4 border-b border-gray-100 dark:border-slate-700 text-right">
                            <a href="{{ route('super_admin.industries.edit', $industry->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('super_admin.industries.destroy', $industry->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
