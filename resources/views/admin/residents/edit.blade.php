@extends('layouts.portal')
@section('title', 'Edit Resident')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Resident: {{ $resident->username }}</h2>
<div class="form-card"><form action="{{ route('admin.residents.update', $resident->id) }}" method="POST">@csrf @method('PUT')
    @include('partials.name_fields', ['resident' => $resident])
    <div class="form-group"><label>Username</label><input type="text" name="username" required value="{{ old('username', $resident->username) }}"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email', $resident->email) }}"></div>
    <div class="form-group"><label>New Password</label><input type="password" name="password"></div>
    <div class="form-group"><label>Address</label><input type="text" name="address" required value="{{ old('address', $resident->address) }}"></div>
    <button type="submit" class="btn-modern">Update</button><a href="{{ route('admin.residents.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
