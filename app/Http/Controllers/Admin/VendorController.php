<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;

class VendorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AppVendor::query(); // Vendors are global
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($v) {
                    $editUrl = route('admin.vendors.edit', $v->id);
                    $deleteUrl = route('admin.vendors.destroy', $v->id);
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
        return view('admin.vendors.index');
    }

    public function create()
    {
        return view('admin.vendors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:100|unique:vendor,business_name',
            'email' => 'required|email|max:50|unique:vendor,email',
            'password' => 'required|string|min:6',
        ]);

        \DB::transaction(function () use ($request) {
            AppVendor::create(array_merge($request->only('business_name', 'email', 'business_registration'), [
                'password' => Hash::make($request->password),
            ]));
        });

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor added.');
    }

    public function edit(int $id)
    {
        $vendor = AppVendor::findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, int $id)
    {
        $vendor = AppVendor::findOrFail($id);
        
        \DB::transaction(function () use ($request, $vendor) {
            $data = $request->only('business_name', 'email', 'business_registration', 'bank_account_details');
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }
            $vendor->update($data);
        });
        
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated.');
    }

    public function destroy(int $id)
    {
        \DB::transaction(function () use ($id) {
            AppVendor::findOrFail($id)->delete();
        });
        
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor removed.');
    }
}
