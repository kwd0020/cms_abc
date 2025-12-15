<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    
    public function showRegister() {
        $tenants = Tenant::all();
        $roles = Role::all();
        return view('auth.register', compact('tenants', 'roles'));   
    }

    public function showLogin() {
        return view('auth.login');
    }

    // Create A New User
    public function register (Request $request){
        $data = $request->validate([
            'user_name' => 'required|string|max:100',
            'user_email' => 'required|email|unique:users',
            'user_role' => 'required|integer|exists:roles,role_id',
            'user_tenant' => 'required|integer|exists:tenants,tenant_id',
            'password'=> 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
        'user_name' => $data['user_name'],
        'user_email' => $data['user_email'],
        'role_id' => $data['user_role'],
        'tenant_id' => $data['user_tenant'],
        'password' => $data['password'],
        ]);

        Auth::login($user);
        return redirect()->route('users.index')->with('success', 'User Created');
    }

    public function login(Request $request){
        
        $data = $request->validate([
            'user_email' => 'required|email',
            'password' => 'required|string'
        ]);

        if(Auth::attempt($data)){
            $request->session()->regenerate();

            return redirect()->route('tickets.index');
        }
        throw ValidationException::withMessages([
            'credentials' => 'Incorrect credentials provided.'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate(); //Removes associated session data
        $request->session()->regenerateToken();

        return redirect()->route('show.login');
    }

}
