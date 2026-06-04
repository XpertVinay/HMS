@extends('layouts.portal')
@section('title', 'View Maintenance Bill')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Maintenance Bill #{{ $maintenance->id }}</h2>
<div class="form-card" style="max-width: 700px;">
    <div class="form-group"><label>Member</label><p>{{ $maintenance->member->username ?? 'N/A' }}</p></div>
    <div class="form-group"><label>Date</label><p>{{ $maintenance->billing_date?->format('M d, Y') }}</p></div>
    <div class="form-group"><label>Total Amount</label><p>₹{{ number_format($maintenance->total_amount, 2) }}</p></div>
    <div class="form-group"><label>Amount Paid</label><p>₹{{ number_format($maintenance->amount_payed, 2) }}</p></div>
    <div class="form-group"><label>Status</label><p><span class="badge-status {{ $maintenance->isPaid() ? 'paid' : 'unpaid' }}">{{ $maintenance->isPaid() ? 'Paid' : 'Unpaid' }}</span></p></div>

    @if($maintenance->items->count())
    <h3 style="margin-top: 20px; font-size: 16px; font-weight: 600;">Line Items</h3>
    <table class="data-table" style="margin-top: 10px;">
        <thead><tr><th>Type</th><th>Reading</th><th>Rate</th><th>Amount</th></tr></thead>
        <tbody>
            @foreach($maintenance->items as $item)
            <tr><td>{{ $item->type_name }}</td><td>{{ $item->reading }}</td><td>{{ $item->rate }}</td><td>₹{{ number_format($item->amount, 2) }}</td></tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @unless($maintenance->isPaid())
    <form action="{{ route('admin.maintenance.pay', $maintenance->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <div class="form-group"><label>Amount Received (₹)</label><input type="number" name="amount_payed" step="0.01" required></div>
        <button type="submit" class="btn-modern btn-success">Record Payment</button>
    </form>
    @endunless

    <a href="{{ route('admin.maintenance.index') }}" class="btn-modern btn-outline" style="margin-top: 16px;">← Back</a>
</div>
@endsection
