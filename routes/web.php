<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

//Ticket Routes
Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::get('/tickets/{ticket_id}', [TicketController::class, 'show'])->name('tickets.show');

//User Routes
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/{user_id}', [UserController::class, 'show'])->name('users.index');
