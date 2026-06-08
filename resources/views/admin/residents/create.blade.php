@extends('layouts.portal')
@section('title', 'Add Resident')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Resident</h2>
<div class="form-card"><form action="{{ route('admin.residents.store') }}" method="POST">@csrf
    @include('partials.name_fields')
    <div class="form-group"><label>Username</label><input type="text" name="username" required value="{{ old('username') }}"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email') }}"></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <div class="form-group"><label>Address</label><input type="text" name="address" required value="{{ old('address') }}"></div>
    <div class="form-group"><label>Mobile</label><input type="text" name="mobile_number" value="{{ old('mobile_number') }}"></div>
    <button type="submit" class="btn-modern">Add Resident</button><a href="{{ route('admin.residents.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
