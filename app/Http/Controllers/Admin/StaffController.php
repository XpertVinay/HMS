<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Staff::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($s) {
                    $editUrl = route('admin.staff.edit', $s->id);
                    $deleteUrl = route('admin.staff.destroy', $s->id);
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
        return view('admin.staff.index');
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:staff,username',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:50|unique:staff,email',
            'password' => 'required|string|min:6',
        ]);

        Staff::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
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
        $data = $request->only('username', 'first_name', 'last_name', 'email', 'mobile_number');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $staffMember->update($data);
        return redirect()->route('admin.staff.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy(int $id)
    {
        Staff::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff removed.');
    }
}
