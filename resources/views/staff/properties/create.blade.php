@extends('layouts.portal')

@section('title', isset($property) ? 'Edit Property' : 'Add Property')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">{{ isset($property) ? 'Edit Property' : 'Add Property' }}</h2>
    <a href="{{ route('staff.properties.index') }}" class="btn-modern btn-outline">Back to List</a>
</div>

<div class="form-card">
    <form action="{{ isset($property) ? route('staff.properties.update', $property->id) : route('staff.properties.store') }}" method="POST">
        @csrf
        @if(isset($property))
            @method('PUT')
        @endif
        
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Basic Information</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label>Property Number <span class="text-red-500">*</span></label>
                <input type="text" name="property_number" value="{{ old('property_number', $property->property_number ?? '') }}" required placeholder="e.g. A-101">
            </div>
            
            <div class="form-group">
                <label>Block / Wing</label>
                <input type="text" name="block" value="{{ old('block', $property->block ?? '') }}" placeholder="e.g. Block A">
            </div>
            
            <div class="form-group">
                <label>Property Type <span class="text-red-500">*</span></label>
                <select name="type" required>
                    <option value="residential" {{ old('type', $property->type ?? '') == 'residential' ? 'selected' : '' }}>Residential</option>
                    <option value="commercial" {{ old('type', $property->type ?? '') == 'commercial' ? 'selected' : '' }}>Commercial</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Assign Owner (Member)</label>
                <select name="owner_id">
                    <option value="">-- No Owner Assigned --</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('owner_id', $property->owner_id ?? '') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }} ({{ $member->username }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4 mt-6">Address Details</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label>Building / Apartment Name</label>
                <input type="text" name="building_name" value="{{ old('building_name', $property->building_name ?? '') }}">
            </div>
            
            <div class="form-group">
                <label>Unit / Flat Number</label>
                <input type="text" name="unit_number" value="{{ old('unit_number', $property->unit_number ?? '') }}">
            </div>
            
            <div class="form-group md:col-span-2">
                <label>Street / Area</label>
                <input type="text" name="street_area" value="{{ old('street_area', $property->street_area ?? '') }}">
            </div>
            
            <div class="form-group">
                <label>City / Town</label>
                <input type="text" name="city_town" value="{{ old('city_town', $property->city_town ?? '') }}">
            </div>
            
            <div class="form-group">
                <label>State</label>
                <input type="text" name="state" value="{{ old('state', $property->state ?? '') }}">
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern w-full">{{ isset($property) ? 'Update Property' : 'Save Property' }}</button>
        </div>
    </form>
</div>
@endsection
