@extends('layouts.portal')
@section('title', 'Add Member')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Member</h2>
<div class="form-card">
    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf
        @include('partials.name_fields')
        <div class="form-group"><label>Username</label><input type="text" name="username" required value="{{ old('username') }}"></div>
        <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email') }}"></div>
        <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
        <div class="form-group"><label>Address</label><input type="text" name="address" required value="{{ old('address') }}"></div>
        <div class="form-group"><label>Phone</label><input type="text" name="phone" value="{{ old('phone') }}" required></div>
        <button type="submit" class="btn-modern">Add Member</button>
        <a href="{{ route('admin.members.index') }}" class="btn-modern btn-outline" style="margin-left: 8px;">Cancel</a>
    </form>
</div>
@endsection
