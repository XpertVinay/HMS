@extends('layouts.portal')
@section('title', 'My Profile')
@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">My Profile</h2>
<div class="form-card">
    <form action="{{ route($role . '.profile.update') }}" method="POST">
        @csrf @method('PUT')
        
        <div class="form-group">
            <label>Username / Login ID</label>
            <input type="text" value="{{ $user->username ?? $user->business_name }}" disabled class="bg-gray-100">
        </div>
        
        @include('partials.name_fields', ['user' => $user])

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        
        <div class="form-group">
            <label>Contact Number</label>
            <input type="text" name="mobile_number" value="{{ old('mobile_number', $user->mobile_number ?? $user->phone ?? '') }}">
        </div>
        
        <div class="form-group">
            <label>New Password (leave blank to keep current)</label>
            <input type="password" name="password">
        </div>
        
        <button type="submit" class="btn-modern">Update Profile</button>
    </form>
</div>
@endsection
