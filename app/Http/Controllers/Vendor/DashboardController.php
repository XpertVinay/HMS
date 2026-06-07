<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ticket;
use App\Models\VendorInvoice;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $vendorId = Auth::guard('vendor')->id();

        $pendingRequests = Ticket::where('assigned_vendor_id', $vendorId)
            ->where('status', '!=', 'resolved')
            ->count();

        $todayCompleted = Ticket::where('assigned_vendor_id', $vendorId)
            ->where('status', 'resolved')
            ->whereDate('updated_at', Carbon::today())
            ->count();

        $totalEarnings = VendorInvoice::where('vendor_id', $vendorId)
            ->where('status', 'paid')
            ->sum('amount');

        return view('vendor.dashboard', compact('pendingRequests', 'todayCompleted', 'totalEarnings'));
    }
}
