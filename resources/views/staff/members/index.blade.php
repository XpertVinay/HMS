@extends('layouts.portal')

@section('title', 'Members Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Members (Owners)</h2>
    <div class="flex gap-3">
        <a href="{{ route('staff.members.create') }}" class="btn-modern">
            <i class='bx bx-user-plus'></i> Add Member
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Name</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Contact</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($members as $member)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 font-medium">#{{ $member->id }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs uppercase">
                                    {{ substr($member->name, 0, 2) }}
                                </div>
                                <div>
                                    <span class="block text-sm font-bold text-gray-800">{{ $member->name }}</span>
                                    <span class="text-xs text-gray-500">{{ $member->username }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <div class="text-sm text-gray-700"><i class='bx bx-envelope text-gray-400'></i> {{ $member->email ?? 'N/A' }}</div>
                            <div class="text-sm text-gray-700"><i class='bx bx-phone text-gray-400'></i> {{ $member->phone ?? 'N/A' }}</div>
                        </td>
                        <td class="p-4">
                            @if($member->is_approved)
                                <span class="px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('staff.members.edit', $member->id) }}" class="btn-modern btn-sm btn-outline">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-gray-500">No members found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($members->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $members->links() }}
        </div>
    @endif
</div>
@endsection
