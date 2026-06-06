<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    public function index()
    {
        $sponsors = Sponsor::where('organization_id', $this->orgId())->get();
        return view('admin.sponsors.index', compact('sponsors'));
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
