<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortalMenu;
use App\Models\CmsPage;
use Illuminate\Http\Request;

class PortalMenuController extends Controller
{
    public function index()
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        $orgId = $isSuperAdmin ? null : $this->orgId();

        $menus = PortalMenu::where('organization_id', $orgId)
            ->with(['children' => function($q) {
                $q->orderBy('order');
            }])
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get();

        $allMenus = PortalMenu::where('organization_id', $orgId)->get();

        // Get CMS pages for the dropdown
        if ($isSuperAdmin) {
            $cmsPages = CmsPage::whereNull('organization_id')->get();
        } else {
            // Include global ones and org ones
            $globalPages = CmsPage::whereNull('organization_id')->get();
            $orgPages = CmsPage::where('organization_id', $orgId)->get()->keyBy('slug');
            
            $cmsPages = collect();
            foreach ($globalPages as $global) {
                if ($orgPages->has($global->slug)) {
                    $cmsPages->push($orgPages->get($global->slug));
                } else {
                    $cmsPages->push($global);
                }
            }
            foreach ($orgPages as $slug => $orgPage) {
                if (!$globalPages->contains('slug', $slug)) {
                    $cmsPages->push($orgPage);
                }
            }
        }

        $standardPages = [
            ['title' => 'Home', 'url' => '/'],
            ['title' => 'Members', 'url' => '/members'],
            ['title' => 'Donors', 'url' => '/donors'],
            ['title' => 'Events', 'url' => '/events'],
            ['title' => 'Notices', 'url' => '/notices'],
            ['title' => 'Sponsors', 'url' => '/sponsors'],
            ['title' => 'Gallery', 'url' => '/gallery'],
            ['title' => 'Login', 'url' => '/login'],
            ['title' => 'Register', 'url' => '/register'],
        ];

        return view('admin.portal_menus.index', compact('menus', 'allMenus', 'cmsPages', 'standardPages'));
    }

    public function store(Request $request)
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        $orgId = $isSuperAdmin ? null : $this->orgId();

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'type' => 'required|in:standard,cms,custom',
            'parent_id' => 'nullable|exists:portal_menus,id',
            'target' => 'required|in:_self,_blank',
        ]);

        $maxOrder = PortalMenu::where('organization_id', $orgId)->where('parent_id', $request->parent_id)->max('order') ?? 0;

        PortalMenu::create([
            'organization_id' => $orgId,
            'title' => $request->title,
            'url' => $request->url,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'target' => $request->target,
            'order' => $maxOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Menu item added successfully.');
    }

    public function update(Request $request, $id)
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        $orgId = $isSuperAdmin ? null : $this->orgId();

        $menu = PortalMenu::where('organization_id', $orgId)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'type' => 'required|in:standard,cms,custom',
            'parent_id' => 'nullable|exists:portal_menus,id',
            'target' => 'required|in:_self,_blank',
        ]);

        // Prevent setting itself as parent
        if ($request->parent_id == $menu->id) {
            return redirect()->back()->with('error', 'Cannot set menu item as its own parent.');
        }

        $menu->update([
            'title' => $request->title,
            'url' => $request->url,
            'type' => $request->type,
            'parent_id' => $request->parent_id,
            'target' => $request->target,
        ]);

        return redirect()->back()->with('success', 'Menu item updated successfully.');
    }

    public function destroy($id)
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        $orgId = $isSuperAdmin ? null : $this->orgId();

        $menu = PortalMenu::where('organization_id', $orgId)->findOrFail($id);
        $menu->delete();

        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $isSuperAdmin = session('account') === 'super_admin' && !session()->has('managed_org_id');
        $orgId = $isSuperAdmin ? null : $this->orgId();

        $order = $request->input('order'); // [{id: 1, parent_id: null, order: 1}, ...]
        if (is_array($order)) {
            foreach ($order as $item) {
                PortalMenu::where('organization_id', $orgId)->where('id', $item['id'])->update([
                    'order' => $item['order'],
                    'parent_id' => $item['parent_id'] ?? null,
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
