@extends('layouts.portal')
@section('title', 'My Maintenance')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">My Maintenance Bills</h2>
<div class="sales-boxes" style="grid-template-columns: 1fr;"><div class="box">
    <table class="data-table">
        <thead><tr><th>#</th><th>Date</th><th>Total</th><th>Paid</th><th>Status</th><th>Action</th></tr></thead>
        <tbody>
            @forelse($maintenances as $i => $m)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $m->billing_date?->format('M d, Y') }}</td>
                <td>₹{{ number_format($m->total_amount,2) }}</td><td>₹{{ number_format($m->amount_payed,2) }}</td>
                <td><span class="badge-status {{ $m->isPaid() ? 'paid' : 'unpaid' }}">{{ $m->isPaid() ? 'Paid' : 'Unpaid' }}</span></td>
                <td><a href="{{ route('member.maintenance.show', $m->id) }}" class="btn-modern btn-sm btn-outline">View</a></td>
            </tr>
            @empty <tr><td colspan="6">No maintenance records.</td></tr> @endforelse
        </tbody>
    </table>
</div></div>
@endsection
