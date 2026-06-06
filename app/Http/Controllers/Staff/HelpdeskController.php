<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\AppVendor;
use App\Models\RwaVendorAlignment;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class HelpdeskController extends Controller
{
    /**
     * View all incoming complaints/tickets.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ticket::with(['member', 'resident', 'vendor'])
                ->where('organization_id', app('active_org')->id);
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('reporter', function ($t) {
                    if ($t->member) return '<span class="font-bold">'.$t->member->username.'</span><br><small class="text-xs text-gray-500">Member</small>';
                    if ($t->resident) return '<span class="font-bold">'.$t->resident->username.'</span><br><small class="text-xs text-gray-500">Resident</small>';
                    return 'N/A';
                })
                ->addColumn('details', function ($t) {
                    $html = '<div class="font-bold text-gray-800">' . $t->subject . '</div>';
                    $html .= '<div class="text-xs text-gray-500 capitalize">Category: ' . $t->category . '</div>';
                    return $html;
                })
                ->addColumn('status', function ($t) {
                    $class = match($t->status) {
                        'resolved' => 'approved',
                        'in_progress' => 'in_progress',
                        default => 'pending',
                    };
                    return "<span class='badge-status {$class}'>" . ucfirst(str_replace('_', ' ', $t->status)) . "</span>";
                })
                ->addColumn('vendor', function ($t) {
                    return $t->vendor ? $t->vendor->name : '<span class="text-xs text-gray-400 italic">Unassigned</span>';
                })
                ->addColumn('date', function ($t) {
                    return $t->created_at ? $t->created_at->format('M d, Y') : '-';
                })
                ->addColumn('actions', function ($t) {
                    $editUrl = route('staff.helpdesk.edit', $t->id);
                    return "<a href='{$editUrl}' class='btn-modern btn-sm btn-outline'>Manage</a>";
                })
                ->rawColumns(['reporter', 'details', 'status', 'vendor', 'actions'])
                ->make(true);
        }
        
        // Get active vendors for this RWA to assign tickets to (not strictly needed in index now, but left if modal used)
        $activeVendorIds = RwaVendorAlignment::where('organization_id', app('active_org')->id)
            ->where('status', 'active')
            ->pluck('vendor_id');
            
        $vendors = AppVendor::whereIn('id', $activeVendorIds)->get();

        return view('staff.helpdesk.index', compact('vendors'));
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
