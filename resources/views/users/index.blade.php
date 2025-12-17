<x-dashboard>
    <h2> View Users </h2>

    <div class="page-card">
        <div class="table-wrapper">
         @if(auth()->user()->hasRole('agent')
            || auth()->user()->hasRole('support_person')
            || auth()->user()->hasRole('manager'))
            <div class="mb-4 flex gap-2">
                <a class="btn" href="{{ route('users.index') }}">All users</a>
            </div>
        @endif
            <div class="table-scroll-y">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">User ID</th>
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Tenant</th>
                            <th class="px-4 py-2">Role</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Phone Number</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="px-4 py-2">{{ $user->user_id }}</td>
                                <td class="px-4 py-2">{{ $user->user_name }}</td>
                                <td class="px-4 py-2">
                                    {{ optional($user->tenant)->tenant_name ?? 'Unknown Tenant' }}
                                    (ID: {{ optional($user->tenant)->tenant_id ?? 'Unknown ID' }})
                                </td>
                                <td class="px-4 py-2">
                                    {{ optional($user->role)->role_name ?? 'Unknown Role' }}
                                    (ID: {{ optional($user->role)->role_id ?? 'Unknown ID' }})
                                </td>
                                <td class="px-4 py-2">{{ $user->user_email }}</td>
                                <td class="px-4 py-2">{{ $user->phone_number }}</td>
                                <td class="px-4 py-2">{{ $user->last_activity }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('users.show', $user->user_id) }}" class="btn">View</a>
                                        
                                        @can('update', $user)
                                            <a href="{{ route('users.edit', $user->user_id) }}" class="btn">Edit</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    {{ $users->links() }}
</x-dashboard>