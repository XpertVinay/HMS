@extends('layouts.portal')
@section('title', 'Edit Staff')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Staff: {{ $staffMember->username }}</h2>
<div class="form-card"><form action="{{ route('admin.staff.update', $staffMember->id) }}" method="POST">@csrf @method('PUT')
    @include('partials.name_fields', ['staffMember' => $staffMember])
    <div class="form-group"><label>Username</label><input type="text" name="username" required value="{{ old('username', $staffMember->username) }}"></div>
    <div class="form-group"><label>Email</label><input type="email" name="email" required value="{{ old('email', $staffMember->email) }}"></div>
    <div class="form-group"><label>New Password</label><input type="password" name="password" required></div>
    <button type="submit" class="btn-modern">Update</button>
    <a href="{{ route('admin.staff.index') }}" class="btn-modern btn-outline" style="margin-left: 8px;">Cancel</a>
</form></div>
@endsection
