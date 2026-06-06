<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('organization_id', $this->orgId())->orderBy('event_date', 'desc')->get();
        return view('admin.events.index', compact('events'));
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
