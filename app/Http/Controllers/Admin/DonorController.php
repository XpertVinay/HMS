<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class DonorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Donor::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('amount', function ($d) {
                    return '₹' . number_format($d->amount, 2);
                })
                ->addColumn('donation_date', function ($d) {
                    return $d->donation_date ? $d->donation_date->format('M d, Y') : '-';
                })
                ->addColumn('actions', function ($d) {
                    $editUrl = route('admin.donors.edit', $d->id);
                    $deleteUrl = route('admin.donors.destroy', $d->id);
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
        return view('admin.donors.index');
    }

    public function create()
    {
        return view('admin.donors.create');
    }

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
