@extends('layouts.portal')
@section('title', 'Add Property')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Property</h2>
<div class="form-card">
    <p class="text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100">
        <i class='bx bx-info-circle text-[var(--primary)]'></i> 
        Enter the property address details. For unstructured or specific regional data (like Tehsil, Post Office, Block), use the "Additional Unstructured Details" field at the bottom.
    </p>

    <form action="{{ route('admin.properties.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-group">
                <label>Unit / Flat / House No.</label>
                <input type="text" name="unit_number" value="{{ old('unit_number') }}" placeholder="e.g. Flat 1204 or House No. 87" required>
            </div>
            <div class="form-group">
                <label>Building / Society Name (Optional)</label>
                <input type="text" name="street_area" value="{{ old('street_area') }}" placeholder="e.g. Sunrise Residency" required>
            </div>
            <div class="form-group">
                <label>Locality / Village / Sector *</label>
                <input type="text" name="locality_village" required value="{{ old('locality_village') }}" placeholder="e.g. Sector 21 or Village Rampur">
            </div>
            <div class="form-group">
                <label>City / Town *</label>
                <input type="text" name="city_town" required value="{{ old('city_town') }}">
            </div>
            <div class="form-group">
                <label>District *</label>
                <input type="text" name="district" required value="{{ old('district') }}">
            </div>
            <div class="form-group">
                <label>State *</label>
                <input type="text" name="state" required value="{{ old('state') }}">
            </div>
            <div class="form-group">
                <label>PIN Code</label>
                <input type="text" name="pincode" value="{{ old('pincode') }}" required>
            </div>
            <div class="form-group">
                <label>Property Type</label>
                <select name="type" required>
                    <option value="flat">Flat</option>
                    <option value="house">House</option>
                    <option value="plot">Plot</option>
                    <option value="shop">Shop</option>
                </select>
            </div>
        </div>

        <div class="form-group mt-4">
            <label>Additional Unstructured Details (Optional)</label>
            <textarea name="unstructured_data" rows="2" placeholder="e.g. Post Office Rampur, Tehsil Bilari... This will be stored dynamically." required>{{ old('unstructured_data') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 border-t border-gray-100 pt-4">
            <div class="form-group">
                <label>Assign Owner</label>
                <select name="owner_id" required>
                    <option value="">None</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}">{{ $m->username }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Assign Resident</label>
                <select name="resident_id" required>
                    <option value="">None</option>
                    @foreach($residents as $r)
                        <option value="{{ $r->id }}">{{ $r->username }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern">Add Property</button>
            <a href="{{ route('admin.properties.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
        </div>
    </form>
</div>
@endsection
