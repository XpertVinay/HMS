<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HelpdeskController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('organization_id', $this->orgId())->with('member')->orderBy('created_at', 'desc')->get();
        return view('admin.helpdesk.index', compact('tickets'));
    }

    public function show(int $id)
    {
        $ticket = Ticket::where('organization_id', $this->orgId())->with('member')->findOrFail($id);
        return view('admin.helpdesk.show', compact('ticket'));
    }

    public function respond(Request $request, int $id)
    {
        $request->validate(['response' => 'required|string', 'status' => 'required|in:pending,in_progress,resolved']);
        $ticket = Ticket::where('organization_id', $this->orgId())->findOrFail($id);
        $ticket->update($request->only('response', 'status'));
        return redirect()->route('admin.helpdesk.show', $id)->with('success', 'Response submitted.');
    }
}
