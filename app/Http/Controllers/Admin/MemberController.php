<?php

namespace App\Http\Controllers\Admin;

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
            $query = Member::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($m) {
                    $editUrl = route('admin.members.edit', $m->id);
                    $deleteUrl = route('admin.members.destroy', $m->id);
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

        return view('admin.members.index');
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
