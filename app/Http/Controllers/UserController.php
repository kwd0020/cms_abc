<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $users = User::orderBy('user_id', 'asc')->get();
        return view('users.index', ["users" => $users]);
    }

    public function show($id) {

    }


}
