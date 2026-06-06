@extends('layouts.portal')

@section('title', 'Bulk Upload Properties')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-bold text-gray-800">Bulk Upload Properties</h2>
    <a href="{{ route('staff.properties.index') }}" class="btn-modern btn-outline">Back to List</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="form-card w-full m-0">
        <form action="{{ route('staff.properties.process_bulk_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-6">
                <div class="p-6 border-2 border-dashed border-indigo-200 rounded-xl bg-indigo-50 text-center">
                    <i class='bx bx-cloud-upload text-5xl text-indigo-400 mb-2'></i>
                    <h3 class="text-lg font-bold text-indigo-900 mb-1">Upload CSV File</h3>
                    <p class="text-sm text-indigo-600 mb-4">Select your properties spreadsheet</p>
                    
                    <input type="file" name="csv_file" accept=".csv" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                </div>
                <p class="text-xs text-gray-500 mt-2"><i class='bx bx-info-circle'></i> Maximum file size is 2MB. Only .csv files allowed.</p>
            </div>
            
            <button type="submit" class="btn-modern w-full">Start Import</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4"><i class='bx bx-info-square text-indigo-600'></i> CSV Format Instructions</h3>
        <p class="text-sm text-gray-600 mb-4">Your CSV file must have headers and follow this exact column structure to import correctly:</p>
        
        <div class="bg-gray-50 rounded border border-gray-200 overflow-hidden mb-4">
            <table class="w-full text-left text-xs">
                <thead class="bg-gray-200 text-gray-700">
                    <tr>
                        <th class="p-2 border-r">Column 1 (A)</th>
                        <th class="p-2 border-r">Column 2 (B)</th>
                        <th class="p-2 border-r">Column 3 (C)</th>
                        <th class="p-2 border-r">Column 4 (D)</th>
                        <th class="p-2">Column 5 (E)</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 font-mono">
                    <tr>
                        <td class="p-2 border-r border-t bg-white">property_number</td>
                        <td class="p-2 border-r border-t bg-white">block</td>
                        <td class="p-2 border-r border-t bg-white">type</td>
                        <td class="p-2 border-r border-t bg-white">unit_number</td>
                        <td class="p-2 border-t bg-white">building_name</td>
                    </tr>
                    <tr>
                        <td class="p-2 border-r border-t">A-101</td>
                        <td class="p-2 border-r border-t">Block A</td>
                        <td class="p-2 border-r border-t">residential</td>
                        <td class="p-2 border-r border-t">101</td>
                        <td class="p-2 border-t">Sunrise Residency</td>
                    </tr>
                    <tr>
                        <td class="p-2 border-r border-t bg-white">S-12</td>
                        <td class="p-2 border-r border-t bg-white"></td>
                        <td class="p-2 border-r border-t bg-white">commercial</td>
                        <td class="p-2 border-r border-t bg-white">12</td>
                        <td class="p-2 border-t bg-white">Main Market Square</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <ul class="text-xs text-gray-500 list-disc pl-4 space-y-1">
            <li><strong>property_number</strong> is REQUIRED.</li>
            <li><strong>type</strong> must be either 'residential' or 'commercial'.</li>
            <li>Other fields are optional but recommended.</li>
        </ul>
    </div>
</div>
@endsection
