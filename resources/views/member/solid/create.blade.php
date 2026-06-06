@extends('layouts.portal')
@section('title', 'Request SOLID Approval')
@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Request SOLID Approval</h2>
    <a href="{{ route('member.solid.index') }}" class="btn-modern btn-outline">Back to Approvals</a>
</div>

<div class="form-card">
    <p class="text-sm text-gray-500 mb-6 pb-4 border-b border-gray-100">
        <i class='bx bx-info-circle text-[var(--primary)]'></i> 
        Depending on the type of approval, a standard fee will be generated as a Maintenance Invoice.
    </p>

    <form action="{{ route('member.solid.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Approval Type</label>
            <select name="approval_type" required id="approvalTypeSelect" class="bg-gray-50">
                <option value="" disabled selected>Select an approval type</option>
                <option value="sale" data-fee="{{ $organization->solid_sale_charge }}">Sale Approval (₹{{ number_format($organization->solid_sale_charge, 2) }})</option>
                <option value="occupancy" data-fee="{{ $organization->solid_occupancy_charge }}">Occupancy / Move-in Approval (₹{{ number_format($organization->solid_occupancy_charge, 2) }})</option>
                <option value="lease" data-fee="{{ $organization->solid_lease_charge }}">Lease / Rent Agreement Approval (₹{{ number_format($organization->solid_lease_charge, 2) }})</option>
                <option value="interior" data-fee="{{ $organization->solid_interior_charge }}">Interior Renovation Approval (₹{{ number_format($organization->solid_interior_charge, 2) }})</option>
                <option value="decoration" data-fee="{{ $organization->solid_decoration_charge }}">Decoration / Event Setup Approval (₹{{ number_format($organization->solid_decoration_charge, 2) }})</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Description & Reason</label>
            <textarea name="description" rows="4" required placeholder="Please provide details about your request..."></textarea>
        </div>
        
        <div class="form-group">
            <label>Supporting Document (Optional)</label>
            <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png">
            <small class="text-gray-500 mt-1 block">E.g., Lease Agreement, Renovation Plan, etc. (Max 5MB)</small>
        </div>
        
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r">
            <p class="text-sm text-blue-800 font-semibold mb-1">Fee Notice</p>
            <p class="text-sm text-blue-700" id="feeNotice">Please select an approval type to see the applicable charges.</p>
        </div>

        <div class="mt-6">
            <button type="submit" class="btn-modern w-full"><i class='bx bx-send'></i> Submit Request & Generate Invoice</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('approvalTypeSelect');
        const notice = document.getElementById('feeNotice');
        
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const fee = parseFloat(selectedOption.getAttribute('data-fee'));
            
            if (fee > 0) {
                notice.innerHTML = `An invoice of <strong>₹${fee.toFixed(2)}</strong> will be automatically generated upon submission. You must pay this invoice before final approval is granted.`;
            } else {
                notice.innerHTML = `There are no processing fees for this approval type.`;
            }
        });
    });
</script>
@endpush
@endsection
