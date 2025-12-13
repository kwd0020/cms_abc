<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index() {
        $tickets = Ticket::orderBy('created_at', 'desc')->get();
        return view('tickets.index', ["tickets" => $tickets]);
    }

    public function show($id) {

    }
}
