<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\MaintenanceItem;
use App\Models\Member;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::where('organization_id', $this->orgId())
            ->with('member')
            ->orderBy('billing_date', 'desc')
            ->get();

        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $members = Member::where('organization_id', $this->orgId())
            ->orderBy('username')
            ->get();

        return view('admin.maintenance.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|integer|exists:member,id',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $maintenance = Maintenance::create([
            'member_id' => $request->member_id,
            'total_amount' => $request->total_amount,
            'amount_payed' => 0,
            'amount_change' => 0,
            'status' => 0,
            'invoice' => '',
            'organization_id' => $this->orgId(),
        ]);

        // Create line items if provided
        if ($request->has('items')) {
            foreach ($request->items as $item) {
                MaintenanceItem::create([
                    'maintenance_id' => $maintenance->id,
                    'type' => $item['type'],
                    'reading' => $item['reading'] ?? 0,
                    'consumption' => $item['consumption'] ?? 0,
                    'rate' => $item['rate'] ?? 0,
                    'previous_reading' => $item['previous_reading'] ?? 0,
                    'previous_consumption' => $item['previous_consumption'] ?? 0,
                    'amount' => $item['amount'] ?? 0,
                    'previous_amount' => $item['previous_amount'] ?? 0,
                    'organization_id' => $this->orgId(),
                ]);
            }
        }

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance bill created successfully.');
    }

    public function show(int $id)
    {
        $maintenance = Maintenance::where('organization_id', $this->orgId())
            ->with(['member', 'items'])
            ->findOrFail($id);

        return view('admin.maintenance.show', compact('maintenance'));
    }

    public function markPaid(Request $request, int $id)
    {
        $maintenance = Maintenance::where('organization_id', $this->orgId())
            ->findOrFail($id);

        $request->validate([
            'amount_payed' => 'required|numeric|min:0',
        ]);

        $maintenance->update([
            'status' => 1,
            'amount_payed' => $request->amount_payed,
            'amount_change' => $request->amount_payed - $maintenance->total_amount,
        ]);

        return redirect()->route('admin.maintenance.show', $id)
            ->with('success', 'Payment recorded successfully.');
    }

    public function destroy(int $id)
    {
        Maintenance::where('organization_id', $this->orgId())
            ->findOrFail($id)
            ->delete();

        return redirect()->route('admin.maintenance.index')
            ->with('success', 'Maintenance record deleted.');
    }
}
