<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

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
        return view('tickets.create');
    }
}
