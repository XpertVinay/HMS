<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Announcement::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('date', function ($a) {
                    return $a->created_at->format('M d, Y H:i');
                })
                ->addColumn('actions', function ($a) {
                    $editUrl = route('admin.announcements.edit', $a->announcement_id);
                    $deleteUrl = route('admin.announcements.destroy', $a->announcement_id);
                    $csrf = csrf_field();
                    $method = method_field('DELETE');
                    return "<a href='{$editUrl}' class='btn-modern btn-sm btn-outline'>Edit</a> 
                            <form action='{$deleteUrl}' method='POST' style='display:inline;' onsubmit='return confirm(\"Delete this announcement?\");'>
                                {$csrf} {$method}
                                <button type='submit' class='btn-modern btn-sm btn-danger'>Delete</button>
                            </form>";
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.announcements.index');
    }

    public function create()
    {
        return view('admin.announcements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'announcement_subject' => 'required|string|max:250',
            'announcement_text' => 'required|string',
        ]);

        Announcement::create([
            'announcement_subject' => $request->announcement_subject,
            'announcement_text' => $request->announcement_text,
            'announcement_status' => 0,
            'organization_id' => $this->orgId(),
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement created successfully.');
    }

    public function edit(int $id)
    {
        $announcement = Announcement::where('organization_id', $this->orgId())
            ->findOrFail($id);

        return view('admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'announcement_subject' => 'required|string|max:250',
            'announcement_text' => 'required|string',
        ]);

        $announcement = Announcement::where('organization_id', $this->orgId())
            ->findOrFail($id);

        $announcement->update($request->only('announcement_subject', 'announcement_text'));

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement updated successfully.');
    }

    public function destroy(int $id)
    {
        Announcement::where('organization_id', $this->orgId())
            ->findOrFail($id)
            ->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }
}
