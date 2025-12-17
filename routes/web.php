<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;



Route::get('/', fn () => view('welcome'))
    ->middleware('guest')
    ->name('welcome');

//Authentication Routes
Route::middleware('guest')->controller(AuthController::class)->group(function(){
    Route::get('/register', 'showRegister')->name('show.register');
    Route::post('/register', 'register')->name('register');
    Route::get('/login', 'showLogin')->name('show.login');
    Route::post('/login', 'login')->name('login');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//Ticket Routes
Route::middleware('auth')->controller(TicketController::class)->group(function (){
    Route::get('/tickets', 'index')->name('tickets.index');
    Route::get('/tickets/create', 'create')->name('tickets.create');
    Route::get('/tickets/{ticket}', 'show')->name('tickets.show');
    Route::post('/tickets', 'store')->name('tickets.store');
    Route::get('/tickets/{ticket}/edit', 'edit')->name('tickets.edit');
    Route::put('/tickets/{ticket}', 'update')->name('tickets.update');
    //Explicit assignment route.
    Route::patch('/tickets/{ticket}/assign', 'assign')->name('tickets.assign');
    //Status + resolution route.
    Route::patch('/tickets/{ticket}/status', 'updateStatus')->name('tickets.status');
    
    Route::delete('/tickets/{ticket}', 'destroy')->name('tickets.destroy');
});

//User Routes
Route::middleware('auth')->controller(UserController::class)->group(function (){
    Route::get('/users',  'index')->name('users.index');
    Route::get('/users/{user}', 'show')->name('users.show');
    Route::POST('/users', 'store')->name('users.store');
    Route::get('/users/{user}/edit', 'edit')->name('users.edit');
    Route::put('users/{user}', 'update')->name('users.update');

});

