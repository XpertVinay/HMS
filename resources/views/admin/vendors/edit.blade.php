@extends('layouts.portal')
@section('title', 'Edit Vendor')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Vendor: {{ $vendor->business_name }}</h2>
<div class="form-card"><form action="{{ route('admin.vendors.update', $vendor->id) }}" method="POST">@csrf @method('PUT')
    <div class="form-group"><label>Business Name</label><input type="text" name="business_name" required value="{{ old('business_name', $vendor->business_name) }}"></div>
    @include('partials.name_fields', ['vendor' => $vendor])
    <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email', $vendor->email) }}"></div>
    <div class="form-group"><label>New Password</label><input type="password" name="password"></div>
    <button type="submit" class="btn-modern">Update</button><a href="{{ route('admin.vendors.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
