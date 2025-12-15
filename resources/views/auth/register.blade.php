<x-dashboard>

    <div class="form-wrapper">
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <!--Validation Errors -->
            @if ($errors->any())
                <div>
                    <ul class="px-4 py-2 bg-red-100">
                        @foreach ($errors->all() as $message)
                            <li class="my-2 text-red-500"> {{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h2>Register A New User</h2>

            <label for="user_name">Full Name</label>
            <input type="text" name="user_name" required value="{{ old('user_name') }}">

            <label for="email">Email: </label>
            <input type="email" name="user_email" required value="{{ old('user_email') }}">

            <label for="user_tenant">Select A Company</label>
            <select name="user_tenant" id="user_tenant" required>
                <option value="" disabled selected>Select a Company</option>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->tenant_id }}" {{ (int) old('user_tenant', $tenant->tenant_id) == (int) $tenant->tenant_id ? 'selected' : '' }}>
                        {{$tenant->tenant_name }}
                    </option>
                @endforeach
            </select>

            <label for="user_role">Select A Role:</label>
            <select name="user_role" id="user_role" required>
                <option value="" disabled selected>Select a Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->role_id }}" {{ (int) old('user_role', $role->role_id) == (int) $role->role_id ? 'selected' : '' }}>
                        {{$role->role_name }}
                    </option>
                @endforeach
            </select>
                
            <label for="password">Password: </label>
            <input type="password" name="password" id="password" required>

            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" required> 

            <div class="text-center">
                <button type="submit" class="btn mt-4">Register</button>
            </div>
            
            

        </form>
    </div>
</x-dashboard>