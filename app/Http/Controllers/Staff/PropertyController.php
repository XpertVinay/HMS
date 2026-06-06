<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Member;
use App\Http\Requests\PropertyRequest;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Yajra\DataTables\Facades\DataTables;

class PropertyController extends Controller
{
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Property::with('owner')->where('organization_id', app('active_org')->id);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('owner', function ($p) {
                    return $p->owner ? $p->owner->name . '<br><small class="text-gray-500">' . $p->owner->username . '</small>' : '<span class="text-gray-400 italic">Unassigned</span>';
                })
                ->addColumn('property_info', function ($p) {
                    $metadata = $p->address_metadata ?? [];
                    $block = !empty($metadata['block']) ? '<span class="text-xs font-bold bg-gray-100 text-gray-600 px-2 py-1 rounded ml-2">Block ' . htmlspecialchars($metadata['block']) . '</span>' : '';
                    return '<strong>' . htmlspecialchars($p->unit_number ?? 'N/A') . '</strong>' . $block;
                })
                ->addColumn('type', function ($p) {
                    return ucfirst($p->type);
                })
                ->addColumn('actions', function ($p) {
                    $editUrl = route('staff.properties.edit', $p->id);
                    return "<a href='{$editUrl}' class='btn-modern btn-sm btn-outline'><i class='bx bx-edit'></i> Edit</a>";
                })
                ->rawColumns(['owner', 'property_info', 'actions'])
                ->make(true);
        }
            
        return view('staff.properties.index');
    }

    public function create()
    {
        $members = Member::where('organization_id', app('active_org')->id)->get();
        return view('staff.properties.create', compact('members'));
    }

    public function store(PropertyRequest $request)
    {
        $this->propertyService->createProperty($request->validated(), app('active_org')->id);

        return redirect()->route('staff.properties.index')->with('success', 'Property added successfully.');
    }

    public function edit($id)
    {
        $property = Property::findOrFail($id);
        $members = Member::where('organization_id', app('active_org')->id)->get();
        return view('staff.properties.edit', compact('property', 'members'));
    }

    public function update(PropertyRequest $request, $id)
    {
        $property = Property::findOrFail($id);
        $this->propertyService->updateProperty($property, $request->validated());

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
        
        $successCount = 0;
        $failureCount = 0;
        $errors = [];
        
        $handle = fopen($path, 'r');
        if ($handle === false) {
            return back()->with('error', 'Failed to open the uploaded file.');
        }

        $header = fgetcsv($handle);
        $rowNumber = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNumber++;
            
            // Expected CSV format: property_number, block, type, unit_number, building_name
            if(count($row) >= 3) {
                DB::beginTransaction();
                try {
                    $data = [
                        'property_number' => $row[0] ?? '',
                        'block' => $row[1] ?? null,
                        'type' => strtolower($row[2]) === 'commercial' ? 'commercial' : 'residential',
                        'unit_number' => $row[3] ?? null,
                        'building_name' => $row[4] ?? null,
                    ];
                    
                    $this->propertyService->createProperty($data, app('active_org')->id);
                    DB::commit();
                    $successCount++;
                } catch (\Exception $e) {
                    DB::rollBack();
                    $failureCount++;
                    $errors[] = "Row $rowNumber: " . $e->getMessage();
                    Log::error("Bulk upload error on row $rowNumber", ['error' => $e->getMessage()]);
                }
            } else {
                $failureCount++;
                $errors[] = "Row $rowNumber: Invalid column count.";
            }
        }
        
        fclose($handle);
        
        if ($failureCount > 0) {
            return redirect()->route('staff.properties.index')->with('warning', "$successCount Properties uploaded successfully. $failureCount failed. Check logs or errors for details.");
        }
        
        return redirect()->route('staff.properties.index')->with('success', "$successCount Properties uploaded successfully.");
    }
}
