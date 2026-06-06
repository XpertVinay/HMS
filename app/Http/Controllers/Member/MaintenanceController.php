<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::where('organization_id', $this->orgId())
            ->where('member_id', session('uid'))
            ->with('items')
            ->orderBy('billing_date', 'desc')
            ->get();

        return view('member.maintenance.index', compact('maintenances'));
    }

    public function show(int $id)
    {
        $maintenance = Maintenance::where('organization_id', $this->orgId())
            ->where('member_id', session('uid'))
            ->with(['items', 'member'])
            ->findOrFail($id);

        return view('member.maintenance.show', compact('maintenance'));
    }
}
