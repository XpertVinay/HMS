<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function index()
    {
        $donors = Donor::where('organization_id', $this->orgId())->orderBy('donation_date', 'desc')->get();
        return view('admin.donors.index', compact('donors'));
    }

    public function create() { return view('admin.donors.create'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100', 'amount' => 'required|numeric|min:0', 'donation_date' => 'required|date']);
        Donor::create(array_merge($request->only('name', 'email', 'amount', 'donation_date'), ['organization_id' => $this->orgId()]));
        return redirect()->route('admin.donors.index')->with('success', 'Donor added.');
    }

    public function edit(int $id)
    {
        $donor = Donor::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.donors.edit', compact('donor'));
    }

    public function update(Request $request, int $id)
    {
        Donor::where('organization_id', $this->orgId())->findOrFail($id)->update($request->only('name', 'email', 'amount', 'donation_date'));
        return redirect()->route('admin.donors.index')->with('success', 'Donor updated.');
    }

    public function destroy(int $id)
    {
        Donor::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.donors.index')->with('success', 'Donor removed.');
    }
}
