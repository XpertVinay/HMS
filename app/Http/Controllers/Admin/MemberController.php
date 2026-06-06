<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::where('organization_id', $this->orgId())
            ->orderBy('username')
            ->get();

        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:member,username',
            'email' => 'required|email|max:50|unique:member,email',
            'password' => 'required|string|min:6',
            'address' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
        ]);

        Member::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'organization_id' => $this->orgId(),
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member added successfully.');
    }

    public function show(int $id)
    {
        $member = Member::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.members.show', compact('member'));
    }

    public function edit(int $id)
    {
        $member = Member::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, int $id)
    {
        $member = Member::where('organization_id', $this->orgId())->findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:50|unique:member,username,' . $id,
            'email' => 'required|email|max:50|unique:member,email,' . $id,
            'address' => 'required|string|max:255',
        ]);

        $data = $request->only('username', 'email', 'address', 'phone');
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $member->update($data);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(int $id)
    {
        Member::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully.');
    }
}
