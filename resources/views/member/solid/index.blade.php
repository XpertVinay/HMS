@extends('layouts.portal')
@section('title', 'SOLID Approvals')
@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">SOLID Approvals</h2>
        <p class="text-sm text-gray-500">Sale, Occupancy, Lease, Interior, Decoration (SOLID)</p>
    </div>
    <a href="{{ route('member.solid.create') }}" class="btn-modern"><i class='bx bx-plus'></i> New Request</a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Request Date</th>
                <th>Charge & Invoice</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approvals as $approval)
            <tr>
                <td>
                    <span class="font-bold text-gray-800 capitalize">{{ $approval->approval_type }} Approval</span>
                    <p class="text-xs text-gray-500 truncate max-w-[200px]">{{ $approval->description }}</p>
                </td>
                <td>{{ $approval->created_at->format('M d, Y') }}</td>
                <td>
                    @if($approval->maintenance_id)
                        <div class="font-semibold text-gray-900">₹{{ number_format($approval->charge_amount, 2) }}</div>
                        <a href="{{ route('member.maintenance.show', $approval->maintenance_id) }}" class="text-xs text-[var(--primary)] hover:underline">
                            <i class='bx bx-receipt'></i> View Invoice
                        </a>
                        @if($approval->maintenance->isPaid())
                            <span class="ml-2 text-xs text-green-600 font-bold">(Paid)</span>
                        @else
                            <span class="ml-2 text-xs text-red-600 font-bold">(Unpaid)</span>
                        @endif
                    @else
                        <span class="text-gray-500">No Charge</span>
                    @endif
                </td>
                <td>
                    @if($approval->status === 'approved')
                        <span class="badge-status approved"><i class='bx bx-check-double'></i> Approved</span>
                    @elseif($approval->status === 'rejected')
                        <span class="badge-status rejected"><i class='bx bx-x'></i> Rejected</span>
                    @elseif($approval->status === 'pending_staff')
                        <span class="badge-status pending"><i class='bx bx-time'></i> Pending Stage 1</span>
                    @elseif($approval->status === 'pending_admin')
                        <span class="badge-status pending"><i class='bx bx-time'></i> Pending Final</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-12 text-gray-500">
                    <i class='bx bx-file text-5xl text-gray-300 mb-3 block'></i>
                    You haven't submitted any SOLID approval requests yet.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $approvals->links() }}
</div>
@endsection
