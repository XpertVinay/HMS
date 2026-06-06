<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class HelpdeskController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('organization_id', $this->orgId())
            ->where('member_id', session('uid'))
            ->orderBy('created_at', 'desc')
            ->get();

        return view('member.helpdesk.index', compact('tickets'));
    }

    public function create() { return view('member.helpdesk.create'); }

    public function store(Request $request)
    {
        $request->validate(['subject' => 'required|string|max:255', 'description' => 'required|string', 'category' => 'required|string|max:100']);
        Ticket::create(array_merge($request->only('subject', 'description', 'category'), [
            'member_id' => session('uid'),
            'organization_id' => $this->orgId(),
        ]));
        return redirect()->route('member.helpdesk.index')->with('success', 'Ticket created.');
    }

    public function show(int $id)
    {
        $ticket = Ticket::where('organization_id', $this->orgId())->where('member_id', session('uid'))->findOrFail($id);
        return view('member.helpdesk.show', compact('ticket'));
    }
}
