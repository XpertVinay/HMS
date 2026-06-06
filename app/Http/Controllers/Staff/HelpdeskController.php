<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\AppVendor;
use App\Models\RwaVendorAlignment;
use Illuminate\Http\Request;

class HelpdeskController extends Controller
{
    /**
     * View all incoming complaints/tickets.
     */
    public function index()
    {
        $tickets = Ticket::with(['member', 'resident', 'vendor'])
            ->where('organization_id', app('active_org')->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Get active vendors for this RWA to assign tickets to
        $activeVendorIds = RwaVendorAlignment::where('organization_id', app('active_org')->id)
            ->where('status', 'active')
            ->pluck('vendor_id');
            
        $vendors = AppVendor::whereIn('id', $activeVendorIds)->get();

        return view('staff.helpdesk.index', compact('tickets', 'vendors'));
    }

    /**
     * Show the form for editing the specified ticket (Update Status & Assign Vendor).
     */
    public function edit($id)
    {
        $ticket = Ticket::with(['member', 'resident', 'vendor'])->findOrFail($id);
        
        $activeVendorIds = RwaVendorAlignment::where('organization_id', app('active_org')->id)
            ->where('status', 'active')
            ->pluck('vendor_id');
            
        $vendors = AppVendor::whereIn('id', $activeVendorIds)->get();

        return view('staff.helpdesk.edit', compact('ticket', 'vendors'));
    }

    /**
     * Update the ticket (Assign Vendor, Update Status, Log Responses).
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
            'response' => 'nullable|string',
            'assigned_vendor_id' => 'nullable|exists:vendor,id',
            'vendor_invoice_amount' => 'nullable|numeric|min:0',
            'vendor_approval_status' => 'nullable|in:pending_vendor,pending_approval,approved,rejected',
        ]);

        $ticket = Ticket::findOrFail($id);
        
        // Handle invoice file upload if present
        if ($request->hasFile('vendor_invoice_file')) {
            $path = $request->file('vendor_invoice_file')->store('invoices', 'public');
            $ticket->vendor_invoice_file = $path;
        }

        $ticket->update([
            'status' => $request->status,
            'response' => $request->response,
            'assigned_vendor_id' => $request->assigned_vendor_id,
            'vendor_invoice_amount' => $request->vendor_invoice_amount,
            'vendor_approval_status' => $request->vendor_approval_status,
        ]);

        return redirect()->route('staff.helpdesk.index')->with('success', 'Ticket updated successfully.');
    }
}
