@extends('layouts.portal')
@section('title', 'Platform Commissions')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h2 style="font-size: 20px; font-weight: 700;">Platform Commissions</h2>
</div>

@if(session('success'))
    <div style="padding: 15px; margin-bottom: 20px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb;">
        {{ session('success') }}
    </div>
@endif

<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <table class="data-table" id="commissions-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Vendor</th>
                    <th>Booking Total</th>
                    <th>Comm. %</th>
                    <th>Comm. Amount</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th class="no-sort">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commissions as $index => $commission)
                    <tr>
                        <td>{{ $commissions->firstItem() + $index }}</td>
                        <td>{{ $commission->vendor->business_name ?? 'N/A' }}</td>
                        <td>${{ number_format($commission->total_booking_amount, 2) }}</td>
                        <td>{{ $commission->commission_percentage }}%</td>
                        <td><strong>${{ number_format($commission->commission_amount, 2) }}</strong></td>
                        <td>
                            @if($commission->status === 'paid')
                                <span style="background: #e6f4ea; color: #1e8e3e; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Paid</span>
                            @else
                                <span style="background: #fef7e0; color: #b06000; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;">Pending</span>
                            @endif
                        </td>
                        <td>{{ $commission->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($commission->status !== 'paid')
                                <form action="{{ route('admin.commissions.pay', $commission->id) }}" method="POST" onsubmit="return confirm('Mark this commission as paid?');" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-modern" style="background: #28a745; color: white; padding: 6px 12px; border: none; cursor: pointer;">
                                        Mark Paid
                                    </button>
                                </form>
                            @else
                                <span style="color: #6c757d; font-size: 13px;">Settled</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            {{ $commissions->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
