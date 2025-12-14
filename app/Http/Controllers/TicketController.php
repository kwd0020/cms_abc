<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Tenant;

class TicketController extends Controller
{
    public function index() {
        $tickets = Ticket::with('user', 'tenant')->orderBy('created_at', 'desc')->paginate(20);
        return view('tickets.index', ["tickets" => $tickets]);
    }

    public function show($ticket_id) {
        $ticket = Ticket::findOrFail($ticket_id);
        return view('tickets.show', ["ticket" => $ticket]);
    }

    public function create(){
        $tenants = Tenant::all();
        $users = User::all();
        $categories = Ticket::categories;
        $priorities = Ticket::priorities;

        return view('tickets.create', compact('tenants', 'users', 'categories', 'priorities'));
    }

    public function store(Request $request){
        $data = $request->validate([
            'ticket_title' => 'required|string|max:100',
            'ticket_description' => 'required|string|max:255',
            'ticket_category' => 'required|in:' . implode(',', Ticket::categories),
            'ticket_priority' => 'required|in:' . implode(',', Ticket::priorities),
            'ticket_user' => 'required||integer|exists:users,user_id',
            'ticket_tenant' => 'required||integer|exists:tenants,tenant_id',
        ]);


        Ticket::create([
        'ticket_title' => $data['ticket_title'],
        'ticket_description' => $data['ticket_description'],
        'ticket_category' => $data['ticket_category'],
        'ticket_priority' => $data['ticket_priority'],
        'user_id' => $data['ticket_user'],
        'tenant_id' => $data['ticket_tenant'],
        'ticket_status' => 'OPEN',
        'ticket_created_at' => now(),
        'ticket_updated_at' => null,
        ]);

        return redirect()->route('tickets.index');
    }
}
