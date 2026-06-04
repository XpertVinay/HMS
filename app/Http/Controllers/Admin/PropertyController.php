<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Member;
use App\Models\Resident;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::where('organization_id', $this->orgId())->with(['owner', 'resident'])->get();
        return view('admin.properties.index', compact('properties'));
    }

    public function create()
    {
        $members = Member::where('organization_id', $this->orgId())->get();
        $residents = Resident::where('organization_id', $this->orgId())->get();
        return view('admin.properties.create', compact('members', 'residents'));
    }

    public function store(Request $request)
    {
        $request->validate(['address' => 'required|string|max:255']);
        Property::create(array_merge($request->only('address', 'type', 'owner_id', 'resident_id'), [
            'organization_id' => $this->orgId(),
        ]));
        return redirect()->route('admin.properties.index')->with('success', 'Property added.');
    }

    public function edit(int $id)
    {
        $property = Property::where('organization_id', $this->orgId())->findOrFail($id);
        $members = Member::where('organization_id', $this->orgId())->get();
        $residents = Resident::where('organization_id', $this->orgId())->get();
        return view('admin.properties.edit', compact('property', 'members', 'residents'));
    }

    public function update(Request $request, int $id)
    {
        $property = Property::where('organization_id', $this->orgId())->findOrFail($id);
        $property->update($request->only('address', 'type', 'owner_id', 'resident_id'));
        return redirect()->route('admin.properties.index')->with('success', 'Property updated.');
    }

    public function destroy(int $id)
    {
        Property::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property removed.');
    }
}
