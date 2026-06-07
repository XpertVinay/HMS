@extends('layouts.portal')
@section('title', 'Super Admin Earnings')

@section('content')
<div class="overview-boxes">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Platform Fee Collected</div>
            <div class="number">₹{{ number_format($platformFeeCollected, 2) }}</div>
            <div style="font-size: 12px; color: #888;">per ticket</div>
        </div>
        <i class='bx bx-coin-stack icon file'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Vendor Invoice Revenue</div>
            <div class="number">₹{{ number_format($revenueFromInvoices, 2) }}</div>
        </div>
        <i class='bx bx-receipt icon staff'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Commission Collected</div>
            <div class="number">₹{{ number_format($commissionCollected, 2) }}</div>
        </div>
        <i class='bx bx-money icon money'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Profit Till Date</div>
            <div class="number" style="color: #1cc88a;">₹{{ number_format($profitTillDate, 2) }}</div>
        </div>
        <i class='bx bx-line-chart icon' style="background: #e0f8e9; color: #1cc88a;"></i>
    </div>
</div>
@endsection
