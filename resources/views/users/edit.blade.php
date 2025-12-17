<x-dashboard>

    <h1> Update User Details </h1>
    <div class="flex flex-col lg:flex-row gap-2 items-start"> 
        <div class="form-wrapper w-full lg:w-3/4">
            <form action="{{ route('users.update', $user->user_id) }}" method="POST">
                @csrf
                @method('PUT')
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


                <h2>user ID - {{$user->user_id}}</h2>

                

                <!--Name-->
                <label for="user_name">Full Name</label>
                <input type="text" name="user_name" required value="{{ old('user_name', $user->user_name) }}">

                <!--Email-->
                <label for="email">Email: </label>
                <input type="email" name="user_email" required value="{{ old('user_email', $user->user_email) }}">
                
                <!--Phone Number-->
                <label for="phone_number">Phone Number</label>
                <input type="tel" id="phone_number" name="phone_number" value="{{old('phone_number', $user->phone_number)}}">

                <!--Tenant-->
                @can('changeTenant', $user)
                    <label for="tenant_id">Tenant</label>
                    <select name="tenant_id" id="tenant_id" required>
                        @foreach($tenants as $tenant)
                        <option value="{{ $tenant->tenant_id }}"
                            @selected((int) old('tenant_id', $user->tenant_id) === (int) $tenant->tenant_id)>
                            {{ $tenant->tenant_name }}
                        </option>
                        @endforeach
                    </select>
                @endcan
                
                <!--Role-->
                <label for="role_id">Select A Role:</label>
                <select name="role_id" id="role_id" required>
                    <option value="" disabled selected>Select a Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->role_id }}"
                            @selected((int) old('role_id', $user->role_id) === (int) $role->role_id)>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>

                
                @can('update', $user)
                    <div class="text-center">
                        <button type="submit" class="btn mt-4">Update user</button>
                    </div>
                @endcan
            </form>
        </div>
    </div>
</x-dashboard>