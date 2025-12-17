<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Validation\Rule;


class TicketController extends Controller
{

    

    public function index() {
        $this->authorize('viewAny', Ticket::class);
        $query = Ticket::with('user', 'tenant')->orderBy('created_at', 'desc');

        if(auth()->user()->hasRole('consumer')){
            $query->where('user_id', auth()->user()->user_id);
        }
        $tickets = $query->paginate(20);
        return view('tickets.index', ["tickets" => $tickets]);
    }

    public function show(Ticket $ticket) {
        $this->authorize('view', $ticket);
        $ticket->load(['user', 'tenant', 'assignee']);
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


        Ticket::create([
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
            'assigned_user_id' => 'nullable',
                'integer',
                Rule::exists('users', 'user_id')->where(fn ($q) =>
                    $q->where('tenant_id', auth()->user()->tenant_id)
                ),
        ]);

        //Ensure that none othher than accepted roles can assign a user to a ticket.
        if ($request->has('assigned_user_id')) {
        $this->authorize('assign', $ticket);

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
        }


        $ticket->update([
            'ticket_title' => $data['ticket_title'],
            'ticket_description' => $data['ticket_description'],
            'ticket_category' => $data['ticket_category'],
            'ticket_priority' => $data['ticket_priority'],
            'assigned_user_id' => $data['assigned_user_id'] ?? $ticket->assigned_user_id, //Nullable
            'ticket_updated_at'  => now(),
        ]);

        return redirect()->route('tickets.show', $ticket->ticket_id)->with('success', 'Ticket Updated');
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

        $ticket->update([
            'assigned_user_id' => $data['assigned_user_id'],
            'ticket_updated_at' => now(),
        ]);

        return redirect()->route('tickets.show', $ticket->ticket_id)->with('success', 'Ticket Assigned');
    }

    public function destroy(Ticket $ticket) {
        $this->authorize('delete', $ticket);
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket Deleted');
    }
}
