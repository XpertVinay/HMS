@extends('layouts.portal')

@section('title', 'Properties Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Properties & Units</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.properties.bulk_upload') }}" class="btn-modern btn-outline">
            <i class='bx bx-upload'></i> Bulk Upload
        </a>
        <a href="{{ route('staff.properties.create') }}" class="btn-modern">
            <i class='bx bx-plus'></i> Add Property
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">Property No</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Type</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Details</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Owner</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($properties as $property)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-800 font-bold">
                            {{ $property->property_number }}
                            @if($property->block)
                                <span class="text-xs font-normal text-gray-500 block">Block: {{ $property->block }}</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="px-2 py-1 rounded text-xs font-bold {{ $property->type == 'commercial' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($property->type) }}
                            </span>
                        </td>
                        <td class="p-4">
                            <span class="block text-sm text-gray-800">{{ $property->building_name ?? 'N/A' }}</span>
                            @if($property->unit_number)
                                <span class="text-xs text-gray-500">Unit: {{ $property->unit_number }}</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($property->owner)
                                <span class="text-sm font-medium text-gray-800">{{ $property->owner->name }}</span>
                            @else
                                <span class="text-sm text-gray-400 italic">No Owner Assigned</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('staff.properties.edit', $property->id) }}" class="btn-modern btn-sm btn-outline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No properties found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($properties->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection
