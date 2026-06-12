@extends('layouts.portal')
@section('title', 'Edit Property')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Property</h2>
<div class="form-card">
    <form action="{{ route('admin.properties.update', $property->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label>Unit / Flat / House No.</label>
                <input type="text" name="unit_number" value="{{ old('unit_number', $property->unit_number) }}">
            </div>
            <div class="form-group">
                <label>Building / Society Name (Optional)</label>
                <input type="text" name="street_area" value="{{ old('street_area', $property->street_area) }}">
            </div>
            <div class="form-group">
                <label>Locality / Village / Sector *</label>
                <input type="text" name="locality_village" required value="{{ old('locality_village', $property->locality_village) }}">
            </div>
            <div class="form-group">
                <label>City / Town *</label>
                <input type="text" name="city_town" required value="{{ old('city_town', $property->city_town) }}">
            </div>
            <div class="form-group">
                <label>District *</label>
                <input type="text" name="district" required value="{{ old('district', $property->district) }}">
            </div>
            <div class="form-group">
                <label>State *</label>
                <input type="text" name="state" required value="{{ old('state', $property->state) }}">
            </div>
            <div class="form-group">
                <label>PIN Code</label>
                <input type="text" name="pincode" value="{{ old('pincode', $property->pincode) }}">
            </div>
            <div class="form-group">
                <label>Property Type</label>
                <select name="type" required>
                    <option value="flat" {{ $property->type == 'flat' ? 'selected' : '' }}>Flat</option>
                    <option value="house" {{ $property->type == 'house' ? 'selected' : '' }}>House</option>
                    <option value="plot" {{ $property->type == 'plot' ? 'selected' : '' }}>Plot</option>
                    <option value="shop" {{ $property->type == 'shop' ? 'selected' : '' }}>Shop</option>
                </select>
            </div>
        </div>

        <div class="form-group mt-4">
            <label>Additional Unstructured Details (Optional)</label>
            <textarea name="unstructured_data" rows="2" required>{{ old('unstructured_data', $property->address_metadata['additional_info'] ?? '') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 border-t border-gray-100 pt-4">
            <div class="form-group">
                <label>Assign Owner</label>
                <select name="owner_id" required>
                    <option value="">None</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}" {{ $property->owner_id == $m->id ? 'selected' : '' }}>{{ $m->username }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Assign Resident</label>
                <select name="resident_id" required>
                    <option value="">None</option>
                    @foreach($residents as $r)
                        <option value="{{ $r->id }}" {{ $property->resident_id == $r->id ? 'selected' : '' }}>{{ $r->username }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern">Update Property</button>
            <a href="{{ route('admin.properties.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
