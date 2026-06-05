@extends('layouts.portal')
@section('title', 'SOLID Approvals (Stage 2)')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">SOLID Approvals Queue <span class="text-sm font-normal text-gray-500 ml-2">(Stage 2 / Final)</span></h2>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="data-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Request Details</th>
                <th>Stage 1 Result</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($approvals as $approval)
            <tr>
                <td class="align-top">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shrink-0">
                            {{ strtoupper(substr($approval->member->username, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-gray-900">{{ $approval->member->username }}</h4>
                            <span class="text-xs text-gray-500">{{ $approval->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </td>
                <td class="align-top max-w-md">
                    <h5 class="font-bold text-gray-900 mb-1 capitalize">{{ $approval->approval_type }} Approval</h5>
                    <p class="text-gray-600 text-sm line-clamp-3">{{ $approval->description }}</p>
                    @if($approval->document_path)
                        <a href="{{ Storage::url($approval->document_path) }}" target="_blank" class="text-[var(--primary)] text-xs mt-2 inline-block"><i class='bx bx-file'></i> View Attached Document</a>
                    @endif
                </td>
                <td class="align-top">
                    @if($approval->stage_1_staff_id)
                        <span class="badge-status approved mb-1"><i class='bx bx-check'></i> Verified Stage 1</span>
                        <p class="text-xs text-gray-500 mt-1">By: {{ $approval->staffReviewer->username ?? 'Staff' }}</p>
                    @else
                        <span class="badge-status in_progress mb-1"><i class='bx bx-bolt-circle'></i> Auto-Skipped Stage 1</span>
                    @endif
                    
                    @if($approval->maintenance_id)
                        <div class="mt-2 text-sm font-semibold">Fee: ₹{{ number_format($approval->charge_amount, 2) }}</div>
                        <span class="text-xs font-bold {{ $approval->maintenance->isPaid() ? 'text-green-600' : 'text-red-600' }}">
                            {{ $approval->maintenance->isPaid() ? 'Paid' : 'Unpaid' }}
                        </span>
                    @endif
                </td>
                <td class="align-top">
                    <div class="flex gap-2">
                        @if(!$approval->maintenance_id || $approval->maintenance->isPaid())
                            <form action="{{ route('admin.solid.approve', $approval->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-modern btn-success btn-sm"><i class='bx bx-check-double'></i> Final Approve</button>
                            </form>
                        @else
                            <button disabled class="btn-modern btn-outline btn-sm opacity-50 cursor-not-allowed" title="Cannot approve until invoice is paid"><i class='bx bx-check-double'></i> Final Approve</button>
                        @endif
                        <form action="{{ route('admin.solid.reject', $approval->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-modern btn-danger btn-sm" onclick="return confirm('Are you sure you want to completely reject this SOLID request?')"><i class='bx bx-x'></i> Reject</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-12 text-gray-500">
                    <i class='bx bx-check-double text-5xl text-gray-300 mb-3 block'></i>
                    No SOLID requests require final approval at this time.
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
