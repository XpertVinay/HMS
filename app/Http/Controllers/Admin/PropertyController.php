<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Member;
use App\Models\Resident;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Property::with(['owner', 'resident'])->where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('address', function ($p) {
                    return Str::limit(trim($p->unit_number . ' ' . $p->street_area . ' ' . $p->locality_village), 40);
                })
                ->addColumn('type', function ($p) {
                    return '<span class="capitalize">' . htmlspecialchars($p->type) . '</span>';
                })
                ->addColumn('owner_name', function ($p) {
                    return $p->owner->username ?? '-';
                })
                ->addColumn('resident_name', function ($p) {
                    return $p->resident->username ?? '-';
                })
                ->addColumn('actions', function ($p) {
                    $editUrl = route('admin.properties.edit', $p->id);
                    $deleteUrl = route('admin.properties.destroy', $p->id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return "<a href='{$editUrl}' class='btn-modern btn-sm btn-outline'><i class='bx bx-edit'></i></a> 
                            <form action='{$deleteUrl}' method='POST' style='display:inline;' onsubmit='return confirm(\"Delete?\");'>
                                {$csrf} {$method}
                                <button type='submit' class='btn-modern btn-sm btn-danger'><i class='bx bx-trash'></i></button>
                            </form>";
                })
                ->rawColumns(['type', 'actions'])
                ->make(true);
        }
        return view('admin.properties.index');
    }

    public function create()
    {
        $members = Member::where('organization_id', $this->orgId())->get();
        $residents = Resident::where('organization_id', $this->orgId())->get();
        return view('admin.properties.create', compact('members', 'residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_number' => 'nullable|string|max:255',
            'street_area' => 'nullable|string|max:255',
            'locality_village' => 'required|string|max:255',
            'city_town' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:50',
            'unstructured_data' => 'nullable|string'
        ]);

        $metadata = null;
        if ($request->filled('unstructured_data')) {
            $metadata = ['additional_info' => $request->unstructured_data];
        }

        Property::create([
            'unit_number' => $request->unit_number,
            'street_area' => $request->street_area,
            'locality_village' => $request->locality_village,
            'city_town' => $request->city_town,
            'district' => $request->district,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address_metadata' => $metadata,
            'type' => $request->type,
            'owner_id' => $request->owner_id,
            'resident_id' => $request->resident_id,
            'organization_id' => $this->orgId(),
        ]);
        return redirect()->route('admin.properties.index')->with('success', 'Property added.');
    }

    public function edit(int $id)
    {
        $property = Property::findOrFail($id);
        $members = Member::all();
        $residents = Resident::all();
        return view('admin.properties.edit', compact('property', 'members', 'residents'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'unit_number' => 'nullable|string|max:255',
            'street_area' => 'nullable|string|max:255',
            'locality_village' => 'required|string|max:255',
            'city_town' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'nullable|string|max:50',
            'unstructured_data' => 'nullable|string'
        ]);

        $property = Property::findOrFail($id);
        
        $metadata = $property->address_metadata ?? [];
        if ($request->filled('unstructured_data')) {
            $metadata['additional_info'] = $request->unstructured_data;
        } else {
            unset($metadata['additional_info']);
        }

        $property->update([
            'unit_number' => $request->unit_number,
            'street_area' => $request->street_area,
            'locality_village' => $request->locality_village,
            'city_town' => $request->city_town,
            'district' => $request->district,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'address_metadata' => empty($metadata) ? null : $metadata,
            'type' => $request->type,
            'owner_id' => $request->owner_id,
            'resident_id' => $request->resident_id,
        ]);
        return redirect()->route('admin.properties.index')->with('success', 'Property updated.');
    }

    public function destroy(int $id)
    {
        Property::findOrFail($id)->delete();
        return redirect()->route('admin.properties.index')->with('success', 'Property removed.');
    }
}
