@extends('layouts.portal')
@section('title', 'Bill Details')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Bill #{{ $maintenance->id }}</h2>
<div class="form-card" style="max-width: 700px;">
    <div class="form-group"><label>Date</label><p>{{ $maintenance->billing_date?->format('M d, Y') }}</p></div>
    <div class="form-group"><label>Total</label><p>₹{{ number_format($maintenance->total_amount, 2) }}</p></div>
    <div class="form-group"><label>Paid</label><p>₹{{ number_format($maintenance->amount_payed, 2) }}</p></div>
    <div class="form-group"><label>Status</label><p><span class="badge-status {{ $maintenance->isPaid() ? 'paid' : 'unpaid' }}">{{ $maintenance->isPaid() ? 'Paid' : 'Unpaid' }}</span></p></div>
    @if($maintenance->items->count())
    <table class="data-table" style="margin-top: 16px;">
        <thead><tr><th>Type</th><th>Reading</th><th>Rate</th><th>Amount</th></tr></thead>
        <tbody>@foreach($maintenance->items as $item)<tr><td>{{ $item->type_name }}</td><td>{{ $item->reading }}</td><td>{{ $item->rate }}</td><td>₹{{ number_format($item->amount, 2) }}</td></tr>@endforeach</tbody>
    </table>
    @endif
    <a href="{{ route('member.maintenance.index') }}" class="btn-modern btn-outline" style="margin-top: 16px;">← Back</a>
</div>
@endsection
