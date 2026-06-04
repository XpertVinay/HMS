<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppVendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = AppVendor::where('organization_id', $this->orgId())->orderBy('business_name')->get();
        return view('admin.vendors.index', compact('vendors'));
    }

    public function create() { return view('admin.vendors.create'); }

    public function store(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:100|unique:vendor,business_name',
            'email' => 'required|email|max:50|unique:vendor,email',
            'password' => 'required|string|min:6',
        ]);

        AppVendor::create(array_merge($request->only('business_name', 'email', 'business_registration'), [
            'password' => Hash::make($request->password),
            'organization_id' => $this->orgId(),
        ]));

        return redirect()->route('admin.vendors.index')->with('success', 'Vendor added.');
    }

    public function edit(int $id)
    {
        $vendor = AppVendor::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.vendors.edit', compact('vendor'));
    }

    public function update(Request $request, int $id)
    {
        $vendor = AppVendor::where('organization_id', $this->orgId())->findOrFail($id);
        $data = $request->only('business_name', 'email', 'business_registration', 'bank_account_details');
        if ($request->filled('password')) { $data['password'] = Hash::make($request->password); }
        $vendor->update($data);
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor updated.');
    }

    public function destroy(int $id)
    {
        AppVendor::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.vendors.index')->with('success', 'Vendor removed.');
    }
}
