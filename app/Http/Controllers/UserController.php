<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $users = User::with('role', 'tenant')->orderBy('user_id', 'asc')->paginate(10);
        return view('users.index', ["users" => $users]);
    }

    public function show($user_id) {
        $user = user::findOrFail($user_id);
        return view('users.show', ["user" => $user]);
    }


}
