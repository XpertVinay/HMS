<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Resident::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('address', function ($r) {
                    return Str::limit($r->address, 30);
                })
                ->addColumn('actions', function ($r) {
                    $editUrl = route('admin.residents.edit', $r->id);
                    $deleteUrl = route('admin.residents.destroy', $r->id);
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
        return view('admin.residents.index');
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
