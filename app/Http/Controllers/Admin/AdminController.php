<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Admin::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($a) {
                    $editUrl = route('admin.admins.edit', $a->id);
                    $deleteUrl = route('admin.admins.destroy', $a->id);
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
        return view('admin.admins.index');
    }

    public function create() { return view('admin.admins.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:admin,username',
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:50|unique:admin,email',
            'mobile_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        Admin::create([
            'username' => $request->username,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'organization_id' => $this->orgId(),
        ]);

        return redirect()->route('admin.admins.index')->with('success', 'Admin added successfully.');
    }

    public function edit(int $id)
    {
        $adminAccount = Admin::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.admins.edit', compact('adminAccount'));
    }

    public function update(Request $request, int $id)
    {
        $adminAccount = Admin::where('organization_id', $this->orgId())->findOrFail($id);
        
        $request->validate([
            'username' => 'required|string|max:50|unique:admin,username,' . $id,
            'email' => 'required|email|max:50|unique:admin,email,' . $id,
        ]);

        $data = $request->only('username', 'first_name', 'last_name', 'email', 'mobile_number');
        if ($request->filled('password')) { $data['password'] = Hash::make($request->password); }
        $adminAccount->update($data);
        return redirect()->route('admin.admins.index')->with('success', 'Admin updated successfully.');
    }

    public function destroy(int $id)
    {
        Admin::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.admins.index')->with('success', 'Admin removed.');
    }
}
