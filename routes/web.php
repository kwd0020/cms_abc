<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', function() {
    $tickets = [
        ["title" => "Unauthorized Transaction","status" => "open", "ticket_id" => "1"],
        ["title" => "Connection Error","status" => "closed", "ticket_id" => "2"],
    ];
    return view('tickets.index', ["greeting" => "hello", "tickets" => $tickets]);
});

Route::get('/tickets/{ticket_id}', function($ticket_id) {
    return view('tickets.show', ["ticket_id" => $ticket_id]);
});

Route::get('/users', function() {
    $users = [
        ["name" => "josh","role" => "systemAdmin", "user_id" => "1"],
        ["name" => "tyrell","role" => "helpdeskAgent", "user_id" => "2"],
    ];
    return view('users.index', ["greeting" => "hello", "users" => $users]);
});

Route::get('/users/{user_id}', function($user_id) {
    return view('users.show', ["user_id" => $user_id]);
});