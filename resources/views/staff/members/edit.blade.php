@extends('layouts.portal')

@section('title', isset($member) ? 'Edit Member' : 'Add Member')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ isset($member) ? 'Edit Member' : 'Add Member' }}</h2>
    <a href="{{ route('staff.members.index') }}" class="btn-modern btn-outline">Back to List</a>
</div>

<div class="form-card">
    <form action="{{ isset($member) ? route('staff.members.update', $member->id) : route('staff.members.store') }}" method="POST">
        @csrf
        @if(isset($member))
            @method('PUT')
        @endif
        
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Account Information</h3>
        
        <div class="grid grid-cols-1 gap-4">
            @include('partials.name_fields', ['member' => $member ?? null])

            <div class="form-group">
                <label>Username (Login ID) <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username', $member->username ?? '') }}" required>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $member->email ?? '') }}">
            </div>
            
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="{{ old('phone', $member->phone ?? '') }}">
            </div>
            
            <div class="form-group">
                <label>{{ isset($member) ? 'New Password (leave blank to keep current)' : 'Password' }} @if(!isset($member))<span class="text-red-500">*</span>@endif</label>
                <input type="password" name="password" {{ isset($member) ? '' : 'required' }}>
            </div>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-800">
            <i class='bx bx-info-circle'></i> Note: Members added by Staff are automatically marked as 'Approved' and can log in immediately.
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern w-full">{{ isset($member) ? 'Update Member' : 'Save Member' }}</button>
        </div>
    </form>
</div>
@endsection
