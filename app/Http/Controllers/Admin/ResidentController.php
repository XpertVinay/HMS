<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResidentController extends Controller
{
    public function index()
    {
        $residents = Resident::where('organization_id', $this->orgId())->orderBy('username')->get();
        return view('admin.residents.index', compact('residents'));
    }

    public function create() { return view('admin.residents.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:resident,username',
            'email' => 'required|email|max:50|unique:resident,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:255',
        ]);

        Resident::create(array_merge($request->only('username', 'email', 'address', 'mobile_number'), [
            'password' => Hash::make($request->password),
            'organization_id' => $this->orgId(),
        ]));

        return redirect()->route('admin.residents.index')->with('success', 'Resident added.');
    }

    public function edit(int $id)
    {
        $resident = Resident::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.residents.edit', compact('resident'));
    }

    public function update(Request $request, int $id)
    {
        $resident = Resident::where('organization_id', $this->orgId())->findOrFail($id);
        $data = $request->only('username', 'email', 'address', 'mobile_number');
        if ($request->filled('password')) { $data['password'] = Hash::make($request->password); }
        $resident->update($data);
        return redirect()->route('admin.residents.index')->with('success', 'Resident updated.');
    }

    public function destroy(int $id)
    {
        Resident::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.residents.index')->with('success', 'Resident removed.');
    }
}
