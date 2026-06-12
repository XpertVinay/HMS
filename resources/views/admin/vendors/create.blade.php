@extends('layouts.portal')
@section('title', 'Add Vendor')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Vendor</h2>
<div class="form-card"><form action="{{ route('admin.vendors.store') }}" method="POST">@csrf
    <div class="form-group"><label>Business Name</label><input type="text" name="business_name" required value="{{ old('business_name') }}"></div>
    @include('partials.name_fields')
    <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email') }}"></div>
    <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
    <div class="form-group"><label>Registration #</label><input type="text" name="business_registration" value="{{ old('business_registration') }}" required></div>
    <button type="submit" class="btn-modern">Add Vendor</button><a href="{{ route('admin.vendors.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
