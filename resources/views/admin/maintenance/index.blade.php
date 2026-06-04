@extends('layouts.portal')
@section('title', 'Maintenance')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Maintenance Billing</h2>
    <a href="{{ route('admin.maintenance.create') }}" class="btn-modern"><i class='bx bx-plus'></i> Create Bill</a>
</div>
<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table">
            <thead><tr><th>#</th><th>Member</th><th>Date</th><th>Total</th><th>Paid</th><th>Status</th><th>Actions</th></tr></thead>
            <tbody>
                @forelse($maintenances as $i => $m)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $m->member->username ?? 'N/A' }}</td>
                    <td>{{ $m->billing_date?->format('M d, Y') }}</td>
                    <td>₹{{ number_format($m->total_amount, 2) }}</td>
                    <td>₹{{ number_format($m->amount_payed, 2) }}</td>
                    <td><span class="badge-status {{ $m->isPaid() ? 'paid' : 'unpaid' }}">{{ $m->isPaid() ? 'Paid' : 'Unpaid' }}</span></td>
                    <td>
                        <a href="{{ route('admin.maintenance.show', $m->id) }}" class="btn-modern btn-sm btn-outline">View</a>
                        <form action="{{ route('admin.maintenance.destroy', $m->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-modern btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7">No maintenance records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
