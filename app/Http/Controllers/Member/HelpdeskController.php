<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class HelpdeskController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Ticket::where('organization_id', $this->orgId())
                ->where('member_id', session('uid'));
                
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('subject', function ($t) {
                    return '<span class="font-bold">' . $t->subject . '</span>';
                })
                ->addColumn('category', function ($t) {
                    return $t->category;
                })
                ->addColumn('status', function ($t) {
                    $class = match($t->status) {
                        'resolved' => 'approved',
                        'in_progress' => 'in_progress',
                        default => 'pending',
                    };
                    return "<span class='badge-status {$class}'>" . ucfirst(str_replace('_', ' ', $t->status)) . "</span>";
                })
                ->addColumn('date', function ($t) {
                    return $t->created_at ? $t->created_at->format('M d, Y') : '-';
                })
                ->addColumn('actions', function ($t) {
                    $showUrl = route('member.helpdesk.show', $t->id);
                    return "<a href='{$showUrl}' class='btn-modern btn-sm btn-outline'>View</a>";
                })
                ->rawColumns(['subject', 'status', 'actions'])
                ->make(true);
        }

        return view('member.helpdesk.index');
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
