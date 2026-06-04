<?php
namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Organization;

class DashboardController extends Controller
{
    public function index()
    {
        $organizations = Organization::withCount(['admins', 'members', 'staff'])->orderBy('created_at', 'desc')->get();
        $pendingCount = Organization::where('status', 'pending')->count();
        $totalCount = Organization::count();

        return view('super_admin.dashboard', compact('organizations', 'pendingCount', 'totalCount'));
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
}
