<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Models\User;
use Illuminate\Validation\Rule;


class TicketController extends Controller
{

    public function index(Request $request) {
        
        $this->authorize('viewAny', Ticket::class);
        $query = Ticket::with('user', 'tenant', 'assignee')->orderBy('created_at', 'desc');
        $pageTitle = 'All Tickets';

        //Consumers only see their own complaint.
        if(auth()->user()->hasRole('consumer')){
            $query->where('user_id', auth()->user()->user_id);
            $pageTitle = 'My Complaints';
        }
        elseif ($request->boolean('mine') && auth()->user()->hasRole('support_person', 'agent')) {
            $query->where('assigned_user_id', auth()->user()->user_id);
            $pageTitle = 'Assigned To Me';
        }

        $tickets = $query->paginate(20)->withQueryString(); //Maintain filter across pages
        return view('tickets.index', compact('tickets', 'pageTitle'));
    }

    public function show(Ticket $ticket) {
        $this->authorize('view', $ticket);
        $ticket->load(['user', 'tenant', 'assignee', 'history.changedBy']);
        return view('tickets.show', ["ticket" => $ticket]);
    }


    public function create(){
        $this->authorize('create', Ticket::class);
        $categories = Ticket::categories;
        $priorities = Ticket::priorities;

        return view('tickets.create', compact('categories', 'priorities'));
    }

    public function store(Request $request){
        $this->authorize('create', Ticket::class);
        $data = $request->validate([
            'ticket_title' => 'required|string|max:100',
            'ticket_description' => 'required|string|max:255',
            'ticket_category' => 'required|in:' . implode(',', Ticket::categories),
            'ticket_priority' => 'required|in:' . implode(',', Ticket::priorities),
        ]);


        $ticket = Ticket::create([
            'ticket_title' => $data['ticket_title'],
            'ticket_description' => $data['ticket_description'],
            'ticket_category' => $data['ticket_category'],
            'ticket_priority' => $data['ticket_priority'],
            'user_id' => auth()->user()->user_id,
            'tenant_id' => auth()->user()->tenant_id,
            'assigned_user_id' => null,
            'ticket_status' => 'OPEN',
            'ticket_created_at' => now(),
            'ticket_updated_at' => null,
        ]);

        $ticket->history()->create([
            'tenant_id' => $ticket->tenant_id,
            'changed_by_user_id' => auth()->user()->user_id,
            'from_status' => null,
            'to_status' => 'OPEN',
            'resolution_note' => 'Ticket Created',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket Created');
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('view', $ticket);
        $this->authorize('update', $ticket);
        $supportUsers = collect();

        //Find support persons under same tenant as current user
        if(auth()->user()->can('assign', $ticket)){
            $supportUsers = User::where('tenant_id', auth()->user()->tenant_id)->whereHas('role', fn ($q) => $q->whereIn('role_slug', ['support_person', 'agent']))->get();
        }
       
        $categories = Ticket::categories;
        $priorities = Ticket::priorities;

        return view('tickets.edit', compact('ticket', 'supportUsers', 'categories', 'priorities'));
    }

    public function update(Request $request, Ticket $ticket){
        $this->authorize('update', $ticket);
        
        $data = $request->validate([
            'ticket_title'  => 'required|string|max:100',
            'ticket_description' => 'required|string|max:255',
            'ticket_category' => 'required|in:' . implode(',', Ticket::categories),
            'ticket_priority'  => 'required|in:' . implode(',', Ticket::priorities),
        ]);


        $ticket->update([
            'ticket_title' => $data['ticket_title'],
            'ticket_description' => $data['ticket_description'],
            'ticket_category' => $data['ticket_category'],
            'ticket_priority' => $data['ticket_priority'],
            'ticket_updated_at'  => now(),
        ]);

        $ticket->history()->create([
            'tenant_id' => $ticket->tenant_id,
            'changed_by_user_id' => auth()->user()->user_id,
            'from_status' => null,
            'to_status' => null,
            'ticket_comment' => 'Ticket details updated',
            'resolution_note' => null,
        ]);

        return redirect()->route('tickets.show', $ticket->ticket_id)->with('success', 'Ticket Updated');
    }


    public function updateStatus(Request $request, Ticket $ticket)
    {
        $this->authorize('updateStatus', $ticket);

        $data = $request->validate([
            'ticket_status' => ['required', Rule::in(['OPEN','IN_PROGRESS','RESOLVED','CLOSED'])],
            'ticket_comment' => ['nullable', 'string', 'max:1000'],
            // Note must be present to close or resolve ticket.
            'resolution_note' => [
                Rule::requiredIf(in_array($request->ticket_status, ['RESOLVED', 'CLOSED'], true)),
                Rule::prohibitedIf(! in_array($request->ticket_status, ['RESOLVED', 'CLOSED'], true)),
                'nullable',
                'string',
                'max:1000',
            ],

            
        ]);

        $oldStatus = $ticket->ticket_status;

        $ticket->update([
            'ticket_status' => $data['ticket_status'],
            'ticket_updated_at' => now(),
        ]);

        $ticket->history()->create([
            'tenant_id' => $ticket->tenant_id,
            'changed_by_user_id' => auth()->user()->user_id,
            'from_status' => $oldStatus,
            'to_status' => $ticket->ticket_status,
            'ticket_comment' => $data['ticket_comment'] ?? null,
            'resolution_note' => $data['resolution_note'] ?? null, // only present when status = RESOLVED
        ]);

        return redirect()->route('tickets.show', $ticket->ticket_id)->with('success', 'Status updated');
    }

    public function assign(Request $request, Ticket $ticket){
        $this->authorize('assign', $ticket);
        $data = $request->validate([
            'assigned_user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'user_id')->where(fn ($q) => $q
                ->where('tenant_id', auth()->user()->tenant_id)),
            ],
        ]);
        if (!empty($data['assigned_user_id'])) {
            $isAssignable = User::whereKey($data['assigned_user_id'])
                ->where('tenant_id', auth()->user()->tenant_id)
                ->whereHas('role', fn ($q) => $q->whereIn('role_slug', ['support_person', 'agent']))
                ->exists();

            if (! $isAssignable) {
                return back()->withErrors([
                    'assigned_user_id' => 'Selected user is not assignable.',
                ])->withInput();
            }
        }

        $oldAssignee = $ticket->assigned_user_id;
        $ticket->update([
            'assigned_user_id' => $data['assigned_user_id'],
            'ticket_updated_at' => now(),
        ]);

        $ticket->history()->create([
            'tenant_id' => $ticket->tenant_id,
            'changed_by_user_id' => auth()->user()->user_id,
            'from_status' => null,
            'to_status' => null,
            'ticket_comment' => 'Assignee changed from '.($oldAssignee ?? 'none').' to '.($data['assigned_user_id'] ?? 'none'),
            'resolution_note' => null,
            
         ]);

        return redirect()->route('tickets.show', $ticket->ticket_id)->with('success', 'Ticket Assigned');
    }

    public function destroy(Ticket $ticket) {
        $this->authorize('delete', $ticket);
        
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket Deleted');
    }
}
