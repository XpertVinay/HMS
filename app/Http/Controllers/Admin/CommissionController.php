<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformCommission;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $orgId = $this->orgId();

        $commissions = PlatformCommission::with(['vendor', 'booking'])
            ->where('organization_id', $orgId)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.commissions.index', compact('commissions'));
    }

    public function markPaid($id)
    {
        $orgId = $this->orgId();
        
        $commission = PlatformCommission::where('organization_id', $orgId)->findOrFail($id);
        $commission->status = 'paid';
        $commission->save();

        return redirect()->back()->with('success', 'Commission marked as paid successfully.');
    }
}
