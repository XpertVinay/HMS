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

        $todayTicketsResolved = \App\Models\Ticket::whereNotNull('assigned_vendor_id')
            ->where('status', 'resolved')
            ->whereDate('updated_at', \Carbon\Carbon::today())
            ->count();

        $todayTicketsPending = \App\Models\Ticket::whereNotNull('assigned_vendor_id')
            ->where('status', 'pending')
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->count();

        return view('super_admin.dashboard', compact('pendingCount', 'totalCount', 'todayTicketsResolved', 'todayTicketsPending'));
    }

    public function approveOrg(int $id)
    {
        $org = Organization::findOrFail($id);
        $org->update(['status' => 'approved']);

        if ($org->industry_id) {
            $industry = \App\Models\Industry::with(['rolePresets', 'menuPreset'])->find($org->industry_id);
            if ($industry) {
                foreach ($industry->rolePresets as $preset) {
                    $role = \Spatie\Permission\Models\Role::firstOrCreate([
                        'name' => $preset->role_name,
                        'guard_name' => 'web',
                        'organization_id' => $org->id,
                    ]);

                    if (!empty($preset->default_permissions) && is_array($preset->default_permissions)) {
                        $role->syncPermissions($preset->default_permissions);
                    }
                }

                // Seed Portal Menus from Industry Preset
                if ($industry->menuPreset && !empty($industry->menuPreset->menu_hierarchy)) {
                    $this->seedMenusFromHierarchy($industry->menuPreset->menu_hierarchy, $org->id, null);
                }
            }
        }

        return redirect()->route('super_admin.dashboard')->with('success', 'Organization approved and default industry roles/menus assigned.');
    }

    private function seedMenusFromHierarchy(array $hierarchy, int $orgId, ?int $parentId = null, &$order = 1)
    {
        foreach ($hierarchy as $item) {
            $menu = \App\Models\PortalMenu::create([
                'organization_id' => $orgId,
                'parent_id' => $parentId,
                'title' => $item['title'] ?? $item['label'] ?? 'Menu',
                'url' => $item['url'] ?? '#',
                'type' => $item['type'] ?? 'standard',
                'order' => $order++,
                'target' => $item['target'] ?? '_self',
                'visibility' => $item['visibility'] ?? 'dashboard',
                'roles' => $item['roles'] ?? null,
                'permissions' => $item['permissions'] ?? null,
                'icon' => $item['icon'] ?? null,
                'route_name' => $item['route_name'] ?? $item['route'] ?? null,
                'is_preset' => true,
            ]);

            if (!empty($item['children'])) {
                $this->seedMenusFromHierarchy($item['children'], $orgId, $menu->id, $order);
            }
        }
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
