@extends('layouts.portal')
@section('title', 'Create Maintenance Bill')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Create Maintenance Bill</h2>
<div class="form-card">
    <form action="{{ route('admin.maintenance.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Member</label>
            <select name="member_id" required>
                <option value="">Select Member</option>
                @foreach($members as $member)
                <option value="{{ $member->id }}">{{ $member->username }} ({{ $member->email }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-group"><label>Total Amount (₹)</label><input type="number" name="total_amount" step="0.01" required value="{{ old('total_amount') }}"></div>
        <button type="submit" class="btn-modern">Create Bill</button>
        <a href="{{ route('admin.maintenance.index') }}" class="btn-modern btn-outline" style="margin-left: 8px;">Cancel</a>
    </form>
</div>
@endsection
