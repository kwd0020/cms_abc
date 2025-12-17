<x-dashboard>
    <h2> {{ $pageTitle }} </h2>

    <div class="page-card">

       
  
        <div class="table-wrapper">
         @if(auth()->user()->hasRole('agent')
            || auth()->user()->hasRole('support_person')
            || auth()->user()->hasRole('manager'))
            <div class="mb-4 flex gap-2">
                <a class="btn" href="{{ route('tickets.index', ['mine' => 1]) }}">My assigned tickets</a>
                <a class="btn" href="{{ route('tickets.index') }}">All tickets</a>
            </div>
        @endif
            <div class="table-scroll-y">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">Ticket ID</th>
                            <th class="px-4 py-2">Category</th>
                            <th class="px-4 py-2">Title</th>
                            <th class="px-4 py-2">Priority</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Owner</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="row {{ $ticket->ticket_status === 'OPEN' ? 'bg-yellow-50' : '' }}">
                                <td class="px-4 py-2">{{ $ticket->ticket_id }}</td>
                                <td class="px-4 py-2">{{ $ticket->ticket_category }}</td>
                                <td class="px-4 py-2">{{ $ticket->ticket_title }}</td>
                                <td class="px-4 py-2">{{ $ticket->ticket_priority }}</td>
                                <td class="px-4 py-2">{{ $ticket->ticket_status }}</td>
                                <td class="px-4 py-2">
                                    {{ optional($ticket->user)->user_name ?? 'Unknown User' }}
                                    (ID: {{ optional($ticket->user)->user_id ?? 'Unknown ID' }})
                                </td>
                                <td class="px-4 py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('tickets.show', $ticket->ticket_id) }}" class="btn">View</a>

                                        @can('update', $ticket)
                                            <a href="{{ route('tickets.edit', $ticket->ticket_id) }}" class="btn">Edit</a>
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

    {{ $tickets->links() }}
</x-dashboard>