<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class HelpdeskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ticket::where('organization_id', $this->orgId())->with('member');
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('member', function ($t) {
                    return $t->member->username ?? 'Unknown';
                })
                ->addColumn('date', function ($t) {
                    return $t->created_at ? $t->created_at->format('M d, Y') : '-';
                })
                ->addColumn('status', function ($t) {
                    $class = match($t->status) {
                        'resolved' => 'approved',
                        'in_progress' => 'in_progress',
                        default => 'pending',
                    };
                    return "<span class='badge-status {$class}'>" . ucfirst(str_replace('_', ' ', $t->status)) . "</span>";
                })
                ->addColumn('actions', function ($t) {
                    $showUrl = route('admin.helpdesk.show', $t->id);
                    return "<a href='{$showUrl}' class='btn-modern btn-sm btn-outline'>View / Respond</a>";
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
        return view('admin.helpdesk.index');
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
