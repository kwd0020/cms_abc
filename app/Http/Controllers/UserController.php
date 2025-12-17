<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Tenant;
use Illuminate\Support\Facades\Hash;
use App\Models\Scopes\TenantScope;


class UserController extends Controller
{
    public function index() {

        $this->authorize('viewAny', User::class);
        $actor = auth()->user();
        $query = User::with('role', 'tenant')->orderBy('user_id', 'asc');

        if (! $actor->hasRole('system_admin')) {
        // show all users
            $query->where('tenant_id', $actor->tenant_id);
        }
       
        $users = $query->paginate(10);
        return view('users.index', compact('users'));
    }

    public function show(User $user) {
        $this->authorize('view', $user);
        return view('users.show', ["user" => $user]);
    }

    public function create() {
        $this->authorize('create', User::class);

        $actor = auth()->user();
        $roles = Role::orderBy('role_name')->get();

        $tenants = $actor->hasRole('system_admin')
        ? Tenant::orderBy('tenant_name')->get()
        : collect();

        return view('users.create', compact('roles', 'tenants', 'actor'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $actor = $request->user();

        $rules = [
            'user_name'     => ['required', 'string', 'max:255'],
            'user_email'    => ['required', 'email', 'unique:users,user_email'],
            'phone_number'  => ['nullable', 'string', 'min:11'],
            'role_id'       => ['required', 'integer', 'exists:roles,role_id'],
            'password'      => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if (! $actor->hasRole('system_admin')) {
            $rules['tenant_id'] = ['prohibited']; // validation fails if tenant_id is submitted
        } else {
            $rules['tenant_id'] = ['required','integer','exists:tenants,tenant_id'];
        }

        $validated = $request->validate($rules);
        // Allow tenant assignment if admin.
        if (! $actor->hasRole('system_admin')) {
            $validated['tenant_id'] = $actor->tenant_id;
        }  

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        return redirect()->route('users.show', $user)->with('success', 'User Created');
    }

    public function edit(User $user){
        $this->authorize('update', $user);

        $actor = auth()->user();

        $roles = Role::orderBy('role_name')->get();

        // Only system admins see tenant dropdown
        $tenants = $actor->hasRole('system_admin')
            ? Tenant::orderBy('tenant_name')->get()
            : collect(); // or null

        return view('users.edit', compact('user', 'roles', 'tenants', 'actor'));
    }

    public function update(Request $request, User $user){

        $this->authorize('update', $user);
        $actor = $request->user();

        

        $rules = [
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => [
                'required', 'email',
                Rule::unique('users', 'user_email')->ignore($user->user_id, 'user_id'),
            ],
            'phone_number' => ['nullable', 'string', 'min:11'],
            'role_id'   => ['required', 'integer'],
        ];

        //Only System Admin can change users tenant.
        if ($actor->hasRole('system_admin')) {
            $rules['tenant_id'] = ['required', 'integer', 'exists:tenants,tenant_id'];
        
        }if ($request->filled('tenant_id')) {
            $this->authorize('changeTenant', $user);
        }

        //Drop any attempts trying to change tenant ID manually
        $validated = $request->validate($rules);
        if (! $actor->hasRole('system_admin')) {
            unset($validated['tenant_id']);
        }

        $user->update($validated);

        return redirect()->route('users.show', $user)->with('success', 'User Updated');
    }


}
