@extends('layouts.portal')
@section('title', 'My Profile')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">My Profile</h2>
<div class="form-card">
    <form action="{{ route('admin.profile.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group"><label>Username</label><input type="text" value="{{ $user->username }}" disabled></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
        <div class="form-group"><label>Mobile</label><input type="text" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number ?? '') }}"></div>
        <div class="form-group"><label>New Password (leave blank to keep)</label><input type="password" name="password"></div>
        <button type="submit" class="btn-modern">Update Profile</button>
    </form>
</div>
@endsection
