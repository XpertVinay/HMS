@extends('layouts.portal')
@section('title', 'SOLID Policies Settings')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">SOLID Approvals Fees & Policies</h2>
</div>

<div class="form-card">
    <p class="text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100">
        <i class='bx bx-cog text-[var(--primary)]'></i> 
        Configure the standard processing fees for each SOLID approval category. When a member requests an approval, an invoice for this amount is automatically generated.
    </p>

    <form action="{{ route('admin.solid.settings.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Sale Approval Fee (₹)</label>
            <input type="number" step="0.01" min="0" name="solid_sale_charge" value="{{ old('solid_sale_charge', $organization->solid_sale_charge) }}" required>
        </div>
        
        <div class="form-group">
            <label>Occupancy / Move-in Approval Fee (₹)</label>
            <input type="number" step="0.01" min="0" name="solid_occupancy_charge" value="{{ old('solid_occupancy_charge', $organization->solid_occupancy_charge) }}" required>
        </div>
        
        <div class="form-group">
            <label>Lease / Rent Agreement Approval Fee (₹)</label>
            <input type="number" step="0.01" min="0" name="solid_lease_charge" value="{{ old('solid_lease_charge', $organization->solid_lease_charge) }}" required>
        </div>
        
        <div class="form-group">
            <label>Interior Renovation Approval Fee (₹)</label>
            <input type="number" step="0.01" min="0" name="solid_interior_charge" value="{{ old('solid_interior_charge', $organization->solid_interior_charge) }}" required>
        </div>
        
        <div class="form-group">
            <label>Decoration / Event Setup Approval Fee (₹)</label>
            <input type="number" step="0.01" min="0" name="solid_decoration_charge" value="{{ old('solid_decoration_charge', $organization->solid_decoration_charge) }}" required>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern w-full"><i class='bx bx-save'></i> Save SOLID Settings</button>
        </div>
    </form>
</div>
@endsection
