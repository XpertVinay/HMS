@extends('layouts.portal')
@section('title', 'Vendor Dashboard')
@section('content')
<div class="overview-boxes">
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Pending Requests</div>
            <div class="number">{{ $pendingRequests }}</div>
        </div>
        <i class='bx bx-time icon file'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Today's Tasks Completed</div>
            <div class="number">{{ $todayCompleted }}</div>
        </div>
        <i class='bx bx-check-circle icon staff'></i>
    </div>
    <div class="box">
        <div class="right-side">
            <div class="box-topic">Total Earnings</div>
            <div class="number">₹{{ number_format($totalEarnings, 2) }}</div>
        </div>
        <i class='bx bx-money icon money'></i>
    </div>
</div>
@endsection
