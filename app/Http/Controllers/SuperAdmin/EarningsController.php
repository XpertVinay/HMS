<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PlatformCommission;
use App\Models\VendorInvoice;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    public function index()
    {
        // 1. Platform fee collected per ticket (Using 0 until specific field is provided by user)
        $platformFeeCollected = 0; 

        // 2. Revenue by invoices from vendors
        $revenueFromInvoices = VendorInvoice::where('status', 'paid')->sum('amount');

        // 3. Commission collected
        $commissionCollected = PlatformCommission::where('status', 'paid')->sum('commission_amount');

        // 4. Profit till date
        $profitTillDate = $commissionCollected + $platformFeeCollected;

        return view('super_admin.earnings', compact(
            'platformFeeCollected',
            'revenueFromInvoices',
            'commissionCollected',
            'profitTillDate'
        ));
    }
}
