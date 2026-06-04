@extends('layouts.portal')
@section('title', 'Add Property')
@section('content')
<h2 style="font-size: 20px; font-weight: 700; margin-bottom: 20px;">Add Property</h2>
<div class="form-card"><form action="{{ route('admin.properties.store') }}" method="POST">@csrf
    <div class="form-group"><label>Address</label><input type="text" name="address" required value="{{ old('address') }}"></div>
    <div class="form-group"><label>Type</label><select name="type"><option value="flat">Flat</option><option value="house">House</option><option value="shop">Shop</option></select></div>
    <div class="form-group"><label>Owner</label><select name="owner_id"><option value="">None</option>@foreach($members as $m)<option value="{{ $m->id }}">{{ $m->username }}</option>@endforeach</select></div>
    <div class="form-group"><label>Resident</label><select name="resident_id"><option value="">None</option>@foreach($residents as $r)<option value="{{ $r->id }}">{{ $r->username }}</option>@endforeach</select></div>
    <button type="submit" class="btn-modern">Add Property</button><a href="{{ route('admin.properties.index') }}" class="btn-modern btn-outline" style="margin-left:8px;">Cancel</a>
</form></div>
@endsection
