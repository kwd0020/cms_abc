<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index() {
        $this->authorize('viewAny', User::class);
        $users = User::with('role', 'tenant')->where('tenant_id', auth()->user()->tenant_id)->orderBy('user_id', 'asc')->paginate(10);
        return view('users.index', ["users" => $users]);
    }

    public function show(User $user) {
        $this->authorize('view', $user);
        return view('users.show', ["user" => $user]);
    }


}
