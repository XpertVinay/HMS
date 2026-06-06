<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Event::where('organization_id', $this->orgId());
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('event_date', function ($e) {
                    return $e->event_date ? $e->event_date->format('M d, Y') : '-';
                })
                ->addColumn('actions', function ($e) {
                    $editUrl = route('admin.events.edit', $e->id);
                    $deleteUrl = route('admin.events.destroy', $e->id);
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
        return view('admin.events.index');
    }

    public function create() { return view('admin.events.create'); }

    public function store(Request $request)
    {
        $request->validate(['title' => 'required|string|max:200', 'event_date' => 'required|date']);
        Event::create(array_merge($request->only('title', 'description', 'event_date', 'event_time'), ['organization_id' => $this->orgId()]));
        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(int $id)
    {
        $event = Event::where('organization_id', $this->orgId())->findOrFail($id);
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, int $id)
    {
        Event::where('organization_id', $this->orgId())->findOrFail($id)->update($request->only('title', 'description', 'event_date', 'event_time'));
        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(int $id)
    {
        Event::where('organization_id', $this->orgId())->findOrFail($id)->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }
}
