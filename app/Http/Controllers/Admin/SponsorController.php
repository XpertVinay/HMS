<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class SponsorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Sponsor::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($s) {
                    $editUrl = route('admin.sponsors.edit', $s->id);
                    $deleteUrl = route('admin.sponsors.destroy', $s->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return "<a href='{$editUrl}' class='btn-modern btn-sm btn-outline'><i class='bx bx-edit'></i></a> 
                            <form action='{$deleteUrl}' method='POST' style='display:inline;' onsubmit='return confirm(\"Delete?\");'>
                                {$csrf} {$method}
                                <button type='submit' class='btn-modern btn-sm btn-danger'><i class='bx bx-trash'></i></button>
                            </form>";
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.sponsors.index');
    }

    public function create() { return view('admin.sponsors.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:150']);
        Sponsor::create(array_merge($request->only('name', 'logo_url', 'description', 'website_url'), ['organization_id' => $this->orgId()]));
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor added.');
    }

    public function edit(int $id)
    {
        $sponsor = Sponsor::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.sponsors.edit', compact('sponsor'));
    }

    public function update(Request $request, int $id)
    {
        Sponsor::where('organization_id', $this->orgId())->findOrFail($id)->update($request->only('name', 'logo_url', 'description', 'website_url'));
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor updated.');
    }

    public function destroy(int $id)
    {
        Sponsor::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.sponsors.index')->with('success', 'Sponsor removed.');
    }
}
