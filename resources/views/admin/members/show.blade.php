@extends('layouts.portal')
@section('title', 'Member Details')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Member: {{ $member->username }}</h2>
<div class="form-card">
    <div class="form-group"><label>Username</label><p>{{ $member->username }}</p></div>
    <div class="form-group"><label>Email</label><p>{{ $member->email }}</p></div>
    <div class="form-group"><label>Address</label><p>{{ $member->address }}</p></div>
    <div class="form-group"><label>Phone</label><p>{{ $member->phone ?: 'N/A' }}</p></div>
    <div class="form-group"><label>Registered</label><p>{{ $member->created_at?->format('M d, Y') }}</p></div>
    <a href="{{ route('admin.members.index') }}" class="btn-modern btn-outline">← Back</a>
</div>
@endsection
