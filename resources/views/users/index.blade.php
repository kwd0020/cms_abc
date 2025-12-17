<x-dashboard>
    <h2> All users </h2>

    <div class="page-wrap mt-4">
        <div class="table-card">
            <div class="table-scroll-y table-scroll-x">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">User ID</th>
                            <th class="px-4 py-2">User Name</th>
                            <th class="px-4 py-2">User Email</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr class="row {{ $user->user_status === 'OPEN' ? 'bg-yellow-50' : '' }}">
                                <td class="px-4 py-2">{{ $user->user_id }}</td>
                                <td class="px-4 py-2">{{ $user->user_name }}</td>
                                <td class="px-4 py-2">{{ $user->user_email }}</td>
                                <td class="px-4 py-2">
                                    {{ optional($user->user)->user_name ?? 'Unknown User' }}
                                    (ID: {{ optional($user->user)->user_id ?? 'Unknown ID' }})
                                </td>
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