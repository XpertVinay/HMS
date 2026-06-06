<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Member;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::with('owner')
            ->where('organization_id', app('active_org')->id)
            ->paginate(15);
            
        return view('staff.properties.index', compact('properties'));
    }

    public function create()
    {
        $members = Member::where('organization_id', app('active_org')->id)->get();
        return view('staff.properties.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_number' => 'required|string|max:100',
            'block' => 'nullable|string|max:100',
            'type' => 'required|in:residential,commercial',
            'owner_id' => 'nullable|exists:member,id',
            'unit_number' => 'nullable|string|max:100',
            'building_name' => 'nullable|string|max:255',
            'street_area' => 'nullable|string|max:255',
            'city_town' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pin_code' => 'nullable|string|max:20',
        ]);

        Property::create([
            'organization_id' => app('active_org')->id,
            'property_number' => $request->property_number,
            'block' => $request->block,
            'type' => $request->type,
            'owner_id' => $request->owner_id,
            'unit_number' => $request->unit_number,
            'building_name' => $request->building_name,
            'street_area' => $request->street_area,
            'city_town' => $request->city_town,
            'district' => $request->district,
            'state' => $request->state,
            'pin_code' => $request->pin_code,
        ]);

        return redirect()->route('staff.properties.index')->with('success', 'Property added successfully.');
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        $members = Member::where('organization_id', app('active_org')->id)->get();
        return view('staff.properties.edit', compact('property', 'members'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_number' => 'required|string|max:100',
            'block' => 'nullable|string|max:100',
            'type' => 'required|in:residential,commercial',
            'owner_id' => 'nullable|exists:member,id',
            'unit_number' => 'nullable|string|max:100',
            'building_name' => 'nullable|string|max:255',
            'street_area' => 'nullable|string|max:255',
            'city_town' => 'nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'pin_code' => 'nullable|string|max:20',
        ]);

        $property = Property::findOrFail($id);
        $property->update($request->all());

        return redirect()->route('staff.properties.index')->with('success', 'Property updated successfully.');
    }
    
    // Bulk Upload
    public function bulkUploadForm()
    {
        return view('staff.properties.bulk_upload');
    }
    
    public function processBulkUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
        
        $path = $request->file('csv_file')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);
        
        $count = 0;
        foreach($data as $row) {
            // Expected CSV format: property_number, block, type, unit_number, building_name
            if(count($row) >= 3) {
                Property::create([
                    'organization_id' => app('active_org')->id,
                    'property_number' => $row[0] ?? '',
                    'block' => $row[1] ?? null,
                    'type' => strtolower($row[2]) === 'commercial' ? 'commercial' : 'residential',
                    'unit_number' => $row[3] ?? null,
                    'building_name' => $row[4] ?? null,
                ]);
                $count++;
            }
        }
        
        return redirect()->route('staff.properties.index')->with('success', "$count Properties uploaded successfully.");
    }
}
