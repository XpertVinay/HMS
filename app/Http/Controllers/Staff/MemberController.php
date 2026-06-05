<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::where('organization_id', app('active_org')->id)
            ->paginate(15);
            
        return view('staff.members.index', compact('members'));
    }

    public function create()
    {
        return view('staff.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:member,username',
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        Member::create([
            'organization_id' => app('active_org')->id,
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'is_approved' => true, // Staff adds them, so auto-approve
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
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:member,username,'.$member->id,
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:20',
        ]);

        $member->update([
            'name' => $request->name,
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
