@extends('layouts.portal')
@section('title', 'Edit Donor')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Donor: {{ $donor->name }}</h2>
<div class="form-card"><form action="{{ route('admin.donors.update', $donor->id) }}" method="POST">@csrf @method('PUT')
    <div class="form-group"><label>Name</label><input type="text" name="name" required value="{{ old('name', $donor->name) }}"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $donor->email) }}"></div>
    <div class="form-group"><label>Amount (₹)</label><input type="number" name="amount" step="0.01" required value="{{ old('amount', $donor->amount) }}"></div>
    <div class="form-group"><label>Date</label><input type="date" name="donation_date" required value="{{ old('donation_date', $donor->donation_date?->format('Y-m-d')) }}"></div>
    <button type="submit" class="btn-modern">Update</button><a href="{{ route('admin.donors.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
