@extends('layouts.portal')

@section('title', 'Helpdesk Management')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Helpdesk & Tickets</h2>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="p-4 text-sm font-semibold text-gray-600">ID</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Requester</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Subject</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Category</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Status</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Vendor</th>
                    <th class="p-4 text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="p-4 text-gray-500 font-medium">#{{ $ticket->id }}</td>
                        <td class="p-4">
                            @if($ticket->member)
                                <span class="block text-sm font-bold text-gray-800">{{ $ticket->member->name }}</span>
                                <span class="text-xs text-gray-500">Member</span>
                            @elseif($ticket->resident)
                                <span class="block text-sm font-bold text-gray-800">{{ $ticket->resident->name }}</span>
                                <span class="text-xs text-gray-500">Resident</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <span class="block text-sm font-medium text-gray-800">{{ $ticket->subject }}</span>
                            <span class="text-xs text-gray-500 truncate block max-w-xs">{{ $ticket->description }}</span>
                        </td>
                        <td class="p-4 text-sm text-gray-600">{{ $ticket->category }}</td>
                        <td class="p-4">
                            @if($ticket->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($ticket->status === 'in_progress')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">In Progress</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">Resolved</span>
                            @endif
                        </td>
                        <td class="p-4">
                            @if($ticket->vendor)
                                <span class="text-sm font-medium text-indigo-600">{{ $ticket->vendor->business_name }}</span>
                                @if($ticket->vendor_approval_status === 'pending_approval')
                                    <br><span class="text-xs text-orange-500 font-bold">Invoice Pending Approval</span>
                                @elseif($ticket->vendor_approval_status === 'approved')
                                    <br><span class="text-xs text-green-500 font-bold">Invoice Approved</span>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">Unassigned</span>
                            @endif
                        </td>
                        <td class="p-4">
                            <a href="{{ route('staff.helpdesk.edit', $ticket->id) }}" class="btn-modern btn-sm text-white">Manage</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">No tickets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($tickets->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $tickets->links() }}
        </div>
    @endif
</div>
@endsection
