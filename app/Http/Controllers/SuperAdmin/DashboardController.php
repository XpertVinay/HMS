<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Organization;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Organization::withCount(['admins', 'members', 'staff']);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('name', function ($org) {
                    return '<strong>' . $org->name . '</strong>';
                })
                ->addColumn('subdomain', function ($org) {
                    return '<code>' . $org->subdomain . '</code>';
                })
                ->addColumn('status', function ($org) {
                    return '<span class="badge-status ' . $org->status . '">' . ucfirst($org->status) . '</span>';
                })
                ->addColumn('actions', function ($org) {
                    $actions = '';
                    $csrf = csrf_field();
                    if ($org->status === 'approved') {
                        $manageUrl = route('super_admin.org.manage', $org->id);
                        $actions .= "<form action='{$manageUrl}' method='POST' style='display:inline;'>{$csrf}<button type='submit' class='btn-modern btn-sm btn-primary'>Manage</button></form>";
                    }
                    if ($org->status === 'pending') {
                        $approveUrl = route('super_admin.org.approve', $org->id);
                        $rejectUrl = route('super_admin.org.reject', $org->id);
                        $actions .= "<form action='{$approveUrl}' method='POST' style='display:inline;'>{$csrf}<button type='submit' class='btn-modern btn-sm btn-success'>Approve</button></form> ";
                        $actions .= "<form action='{$rejectUrl}' method='POST' style='display:inline;'>{$csrf}<button type='submit' class='btn-modern btn-sm btn-danger'>Reject</button></form>";
                    } elseif ($org->status !== 'approved') {
                        $actions .= "<span style='color: #888; font-size: 12px;'>" . ucfirst($org->status) . "</span>";
                    }
                    return $actions;
                })
                ->rawColumns(['name', 'subdomain', 'status', 'actions'])
                ->make(true);
        }

        $pendingCount = Organization::where('status', 'pending')->count();
        $totalCount = Organization::count();

        return view('super_admin.dashboard', compact('pendingCount', 'totalCount'));
    }

    public function approveOrg(int $id)
    {
        Organization::findOrFail($id)->update(['status' => 'approved']);
        return redirect()->route('super_admin.dashboard')->with('success', 'Organization approved.');
    }

    public function rejectOrg(int $id)
    {
        Organization::findOrFail($id)->update(['status' => 'rejected']);
        return redirect()->route('super_admin.dashboard')->with('success', 'Organization rejected.');
    }

    public function manageOrg(int $id)
    {
        $org = Organization::findOrFail($id);
        session(['managed_org_id' => $org->id, 'managed_org_name' => $org->name]);
        return redirect()->route('admin.admins.index')->with('success', "Now managing {$org->name}");
    }

    public function stopManaging()
    {
        session()->forget(['managed_org_id', 'managed_org_name']);
        return redirect()->route('super_admin.dashboard');
    }
}
