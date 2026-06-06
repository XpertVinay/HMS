@extends('layouts.portal')

@section('title', 'Manage Ticket #' . $ticket->id)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Manage Ticket #{{ $ticket->id }}</h2>
    <a href="{{ route('staff.helpdesk.index') }}" class="btn-modern btn-outline">Back to List</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Ticket Details -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Ticket Details</h3>
        <div class="space-y-4">
            <div>
                <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Requester</label>
                <div class="text-gray-800 font-medium text-lg">
                    @if($ticket->member)
                        {{ $ticket->member->name }} <span class="text-sm font-normal text-gray-500">(Member)</span>
                    @elseif($ticket->resident)
                        {{ $ticket->resident->name }} <span class="text-sm font-normal text-gray-500">(Resident)</span>
                    @endif
                </div>
            </div>
            
            <div>
                <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Subject</label>
                <div class="text-gray-800 font-medium">{{ $ticket->subject }}</div>
            </div>
            
            <div>
                <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Description</label>
                <div class="text-gray-600 bg-gray-50 p-4 rounded-lg mt-1 whitespace-pre-wrap">{{ $ticket->description }}</div>
            </div>
        </div>

        <div class="mt-8 border-t pt-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Communication History</h3>
            
            <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2">
                @if($ticket->response)
                    <div class="bg-indigo-50 p-4 rounded-lg rounded-tr-none ml-auto max-w-[85%]">
                        <p class="text-sm text-gray-800">{{ $ticket->response }}</p>
                        <small class="text-xs text-gray-500 mt-2 block">Legacy Response</small>
                    </div>
                @endif
                
                @foreach($ticket->messages as $msg)
                    @if($msg->sender_type === 'staff')
                        <div class="bg-indigo-50 p-4 rounded-lg rounded-tr-none ml-auto max-w-[85%]">
                            <p class="text-sm text-gray-800">{{ $msg->message }}</p>
                            <small class="text-xs text-gray-500 mt-2 block">You • {{ $msg->created_at->format('M d, h:i A') }}</small>
                        </div>
                    @else
                        <div class="bg-gray-100 p-4 rounded-lg rounded-tl-none mr-auto max-w-[85%]">
                            <p class="text-sm text-gray-800">{{ $msg->message }}</p>
                            <small class="text-xs text-gray-500 mt-2 block">{{ ucfirst($msg->sender_type) }} • {{ $msg->created_at->format('M d, h:i A') }}</small>
                        </div>
                    @endif
                @endforeach
            </div>

            <form action="{{ route('staff.helpdesk.reply', $ticket->id) }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="message" required class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-100" placeholder="Type a reply to the reporter...">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition"><i class='bx bx-send'></i></button>
            </form>
        </div>
    </div>

    <!-- Management Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Update & Assign</h3>
        
        <form action="{{ route('staff.helpdesk.update', $ticket->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Ticket Status</label>
                <select name="status" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-100 focus:border-indigo-500 transition">
                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-gray-700 mb-2">Assign Vendor</label>
                <select name="assigned_vendor_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-100 transition">
                    <option value="">-- No Vendor Assigned --</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ $ticket->assigned_vendor_id == $vendor->id ? 'selected' : '' }}>
                            {{ $vendor->business_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <h4 class="font-bold text-gray-700 mb-3"><i class='bx bx-receipt'></i> Vendor Invoice Details</h4>
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Invoice Amount (₹)</label>
                        <input type="number" step="0.01" name="vendor_invoice_amount" value="{{ $ticket->vendor_invoice_amount }}" class="w-full p-2 border border-gray-300 rounded-lg" placeholder="e.g. 500.00">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Invoice Document</label>
                        @if($ticket->vendor_invoice_file)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $ticket->vendor_invoice_file) }}" target="_blank" class="text-sm text-indigo-600 font-medium flex items-center gap-1">
                                    <i class='bx bx-file'></i> View Current Invoice
                                </a>
                            </div>
                        @endif
                        <input type="file" name="vendor_invoice_file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Approval Status</label>
                        <select name="vendor_approval_status" class="w-full p-2 border border-gray-300 rounded-lg">
                            <option value="">-- N/A --</option>
                            <option value="pending_vendor" {{ $ticket->vendor_approval_status == 'pending_vendor' ? 'selected' : '' }}>Waiting for Vendor Invoice</option>
                            <option value="pending_approval" {{ $ticket->vendor_approval_status == 'pending_approval' ? 'selected' : '' }}>Waiting for Member/Admin Approval</option>
                            <option value="approved" {{ $ticket->vendor_approval_status == 'approved' ? 'selected' : '' }}>Invoice Approved</option>
                            <option value="rejected" {{ $ticket->vendor_approval_status == 'rejected' ? 'selected' : '' }}>Invoice Rejected</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">Staff Response / Remarks</label>
                <textarea name="response" rows="4" class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-indigo-100 transition" placeholder="Add resolution remarks...">{{ $ticket->response }}</textarea>
            </div>
            
            <button type="submit" class="btn-modern w-full">Update Ticket</button>
        </form>
    </div>
</div>
@endsection
