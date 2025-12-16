<x-dashboard>
    <h2> All Tickets </h2>

    <ul>
        @foreach($tickets as $ticket)
            <li>
                <x-card href="{{ route('tickets.show', $ticket->ticket_id) }}" :highlight="$ticket['status'] == 'OPEN' ">
                    <div>
                        <h3>
                            {{$ticket->ticket_id}} | 
                            {{$ticket->ticket_category}} | 
                            {{$ticket->ticket_title}} | 
                            {{$ticket->ticket_priority}} | 
                            {{$ticket->ticket_status}}
                        </h3>
                        <p>{{optional($ticket->user)->user_name ?? 'Unknown User'}} | ID: {{optional($ticket->user)->user_id ?? 'Unknown ID'}}</p>
                    </div>
                    
                </x-card>
            </li>
        @endforeach
    </ul>

    {{ $tickets->links() }}
</x-dashboard>