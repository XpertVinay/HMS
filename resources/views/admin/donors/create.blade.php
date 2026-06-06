@extends('layouts.portal')
@section('title', 'Add Donor')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Donor</h2>
<div class="form-card"><form action="{{ route('admin.donors.store') }}" method="POST">@csrf
    <div class="form-group"><label>Name</label><input type="text" name="name" required value="{{ old('name') }}"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}"></div>
    <div class="form-group"><label>Amount (₹)</label><input type="number" name="amount" step="0.01" required value="{{ old('amount') }}"></div>
    <div class="form-group"><label>Date</label><input type="date" name="donation_date" required value="{{ old('donation_date', date('Y-m-d')) }}"></div>
    <button type="submit" class="btn-modern">Add Donor</button><a href="{{ route('admin.donors.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
