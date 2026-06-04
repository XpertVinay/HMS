<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::where('organization_id', $this->orgId())->orderBy('username')->get();
        return view('admin.staff.index', compact('staff'));
    }

    public function create() { return view('admin.staff.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:staff,username',
            'email' => 'required|email|max:50|unique:staff,email',
            'password' => 'required|string|min:6',
        ]);

        Staff::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $this->orgId(),
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff added successfully.');
    }

    public function edit(int $id)
    {
        $staffMember = Staff::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.staff.edit', compact('staffMember'));
    }

    public function update(Request $request, int $id)
    {
        $staffMember = Staff::where('organization_id', $this->orgId())->findOrFail($id);
        $data = $request->only('username', 'email', 'mobile_number');
        if ($request->filled('password')) { $data['password'] = Hash::make($request->password); }
        $staffMember->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(int $id)
    {
        Staff::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff removed.');
    }
}
