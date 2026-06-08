@extends('layouts.portal')
@section('title', 'Edit Admin')
@section('content')
<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <div class="box-title">Edit Admin</div>
        <form action="{{ route('admin.admins.update', $adminAccount->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('partials.name_fields', ['adminAccount' => $adminAccount])
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username', $adminAccount->username) }}" required style="width: 100%; padding: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $adminAccount->email) }}" required style="width: 100%; padding: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Mobile Number</label>
                <input type="text" name="mobile_number" class="form-control" value="{{ old('mobile_number', $adminAccount->mobile_number) }}" style="width: 100%; padding: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Password (Leave blank to keep current)</label>
                <input type="password" name="password" class="form-control" style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" class="btn-modern btn-primary">Update</button>
            <a href="{{ route('admin.admins.index') }}" class="btn-modern" style="background: #ccc; color: #333;">Cancel</a>
        </form>
    </div>
</div>
@endsection
