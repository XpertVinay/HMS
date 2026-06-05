@extends('layouts.portal')

@section('title', 'Residents Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Residents (Tenants)</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.residents.create') }}" class="btn-modern">
            <i class='bx bx-user-plus'></i> Add Resident
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Username</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Contact</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Verification</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($residents as $resident)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 font-medium">#{{ $resident->id }}</td>
                        <td class="p-4">
                            <span class="block text-sm font-bold text-gray-800">{{ $resident->username }}</span>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-gray-700"><i class='bx bx-envelope text-gray-400'></i> {{ $resident->email ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-700"><i class='bx bx-phone text-gray-400'></i> {{ $resident->mobile_number ?? 'N/A' }}</div>
                        </td>
                        <td class="p-4">
                            @if($resident->is_rent_agreement_verified_staff)
                                <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">Verified by Staff</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-800">Pending Verification</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('staff.residents.edit', $resident->id) }}" class="btn-modern btn-sm btn-outline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No residents found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($residents->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $residents->links() }}
        </div>
    @endif
</div>
@endsection
