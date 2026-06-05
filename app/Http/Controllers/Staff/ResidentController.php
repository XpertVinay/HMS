<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::where('organization_id', app('active_org')->id)
            ->paginate(15);
            
        return view('staff.residents.index', compact('residents'));
    }

    public function create()
    {
        return view('staff.residents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:resident,username',
            'email' => 'required|email|max:50|unique:resident,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
        ]);

        Resident::create([
            'organization_id' => app('active_org')->id,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
            'is_rent_agreement_verified_staff' => true, // Staff auto-verifies
        ]);

        return redirect()->route('staff.residents.index')->with('success', 'Resident added successfully.');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('staff.residents.edit', compact('resident'));
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:50|unique:resident,username,'.$resident->id,
            'email' => 'required|email|max:50|unique:resident,email,'.$resident->id,
            'address' => 'required|string|max:255',
            'mobile_number' => 'nullable|string|max:20',
        ]);

        $resident->update([
            'username' => $request->username,
            'email' => $request->email,
            'address' => $request->address,
            'mobile_number' => $request->mobile_number,
        ]);

        if ($request->filled('password')) {
            $resident->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('staff.residents.index')->with('success', 'Resident updated successfully.');
    }
}
