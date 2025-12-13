<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', [TicketController::class, 'index']);

Route::get('/tickets/create', function () {
    return view('tickets.create');
});


Route::get('/tickets/{ticket_id}', function($ticket_id) {
    return view('tickets.show', ["ticket_id" => $ticket_id]);
});

Route::get('/users', [UserController::class, 'index']); 

Route::get('/users/{user_id}', function($user_id) {
    return view('users.show', ["user_id" => $user_id]);
});