@extends('layouts.portal')
@section('title', 'Edit Member')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Member: {{ $member->username }}</h2>
<div class="form-card">
    <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group"><label>Username</label><input type="text" name="username" required value="{{ old('username', $member->username) }}"></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email', $member->email) }}"></div>
        <div class="form-group"><label>New Password (leave blank to keep)</label><input type="password" name="password"></div>
        <div class="form-group"><label>Address</label><input type="text" name="address" required value="{{ old('address', $member->address) }}"></div>
        <div class="form-group"><label>Phone</label><input type="text" name="phone" value="{{ old('phone', $member->phone) }}"></div>
        <button type="submit" class="btn-modern">Update Member</button>
        <a href="{{ route('admin.members.index') }}" class="btn-modern btn-outline" style="margin-left: 8px;">Cancel</a>
    </form>
</div>
@endsection
