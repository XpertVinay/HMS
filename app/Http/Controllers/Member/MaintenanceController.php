<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Maintenance::where('organization_id', $this->orgId())
                ->where('member_id', session('uid'));
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('month', function ($m) {
                    return $m->billing_date ? \Carbon\Carbon::parse($m->billing_date)->format('F Y') : '-';
                })
                ->addColumn('amount', function ($m) {
                    return '₹' . number_format($m->total_amount, 2);
                })
                ->addColumn('due_date', function ($m) {
                    return $m->due_date ? \Carbon\Carbon::parse($m->due_date)->format('M d, Y') : '-';
                })
                ->addColumn('status', function ($m) {
                    $class = match($m->status) {
                        'paid' => 'approved',
                        'overdue' => 'rejected',
                        default => 'pending',
                    };
                    return "<span class='badge-status {$class}'>" . ucfirst($m->status) . "</span>";
                })
                ->addColumn('actions', function ($m) {
                    $showUrl = route('member.maintenance.show', $m->id);
                    return "<a href='{$showUrl}' class='btn-modern btn-sm btn-outline'>View Invoice</a>";
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }

        return view('member.maintenance.index');
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
