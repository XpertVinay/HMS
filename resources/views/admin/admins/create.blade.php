@extends('layouts.portal')
@section('title', 'Add Admin')
@section('content')
<div class="sales-boxes" style="grid-template-columns: 1fr;">
    <div class="box">
        <div class="box-title">Add New Admin</div>
        <form action="{{ route('admin.admins.store') }}" method="POST">
            @csrf
            @include('partials.name_fields')
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required style="width: 100%; padding: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 15px;">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required style="width: 100%; padding: 8px;">
            </div>
            <button type="submit" class="btn-modern btn-primary">Save</button>
            <a href="{{ route('admin.admins.index') }}" class="btn-modern" style="background: #ccc; color: #333;">Cancel</a>
        </form>
    </div>
</div>
@endsection
