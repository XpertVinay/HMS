@extends('layouts.portal')
@section('title', 'Edit Property')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Edit Property</h2>
<div class="form-card"><form action="{{ route('admin.properties.update', $property->id) }}" method="POST">@csrf @method('PUT')
    <div class="form-group"><label>Address</label><input type="text" name="address" required value="{{ old('address', $property->address) }}"></div>
    <div class="form-group"><label>Type</label><select name="type"><option value="flat" {{ $property->type === 'flat' ? 'selected' : '' }}>Flat</option><option value="house" {{ $property->type === 'house' ? 'selected' : '' }}>House</option><option value="shop" {{ $property->type === 'shop' ? 'selected' : '' }}>Shop</option></select></div>
    <div class="form-group"><label>Owner</label><select name="owner_id"><option value="">None</option>@foreach($members as $m)<option value="{{ $m->id }}" {{ $property->owner_id == $m->id ? 'selected' : '' }}>{{ $m->username }}</option>@endforeach</select></div>
    <div class="form-group"><label>Resident</label><select name="resident_id"><option value="">None</option>@foreach($residents as $r)<option value="{{ $r->id }}" {{ $property->resident_id == $r->id ? 'selected' : '' }}>{{ $r->username }}</option>@endforeach</select></div>
    <button type="submit" class="btn-modern">Update</button><a href="{{ route('admin.properties.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
