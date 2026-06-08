<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Yajra\DataTables\Facades\DataTables;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Member::where('organization_id', app('active_org')->id);
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($m) {
                    $editUrl = route('staff.members.edit', $m->id);
                    return "<a href='{$editUrl}' class='btn-modern btn-sm btn-outline'><i class='bx bx-edit'></i> Edit</a>";
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
            
        return view('staff.members.index');
    }

    public function create()
    {
        return view('staff.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:member,username',
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        Member::create([
            'organization_id' => app('active_org')->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('staff.members.index')->with('success', 'Member added successfully.');
    }

    public function edit($id)
    {
        $member = Member::findOrFail($id);
        return view('staff.members.edit', compact('member'));
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        
        $request->validate([
            'first_name' => 'nullable|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'username' => 'required|string|max:50|unique:member,username,'.$member->id,
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:20',
        ]);

        $member->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->filled('password')) {
            $member->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('staff.members.index')->with('success', 'Member updated successfully.');
    }
}
