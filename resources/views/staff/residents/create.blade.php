@extends('layouts.portal')

@section('title', isset($resident) ? 'Edit Resident' : 'Add Resident')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ isset($resident) ? 'Edit Resident' : 'Add Resident' }}</h2>
    <a href="{{ route('staff.residents.index') }}" class="btn-modern btn-outline">Back to List</a>
</div>

<div class="form-card">
    <form action="{{ isset($resident) ? route('staff.residents.update', $resident->id) : route('staff.residents.store') }}" method="POST">
        @csrf
        @if(isset($resident))
            @method('PUT')
        @endif
        
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Account Information</h3>
        
        <div class="grid grid-cols-1 gap-4">
            <div class="form-group">
                <label>Username (Login ID) <span class="text-red-500">*</span></label>
                <input type="text" name="username" value="{{ old('username', $resident->username ?? '') }}" required>
            </div>
            
            <div class="form-group">
                <label>Email Address <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $resident->email ?? '') }}" required>
            </div>
            
            <div class="form-group">
                <label>Mobile Number</label>
                <input type="text" name="mobile_number" value="{{ old('mobile_number', $resident->mobile_number ?? '') }}">
            </div>

            <div class="form-group">
                <label>Full Address <span class="text-red-500">*</span></label>
                <input type="text" name="address" value="{{ old('address', $resident->address ?? '') }}" required placeholder="Flat/Unit No, Building">
            </div>
            
            <div class="form-group">
                <label>{{ isset($resident) ? 'New Password (leave blank to keep current)' : 'Password' }} @if(!isset($resident))<span class="text-red-500">*</span>@endif</label>
                <input type="password" name="password" {{ isset($resident) ? '' : 'required' }}>
            </div>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-100 rounded-lg text-sm text-blue-800">
            <i class='bx bx-info-circle'></i> Note: Residents added by Staff are automatically marked as 'Verified by Staff' and can log in immediately.
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern w-full">{{ isset($resident) ? 'Update Resident' : 'Save Resident' }}</button>
        </div>
    </form>
</div>
@endsection
