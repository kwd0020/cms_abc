<x-dashboard>
    <h2> All Tickets </h2>

    <ul>
        @foreach($tickets as $ticket)
            <li>
                <x-card href="/tickets/{{$ticket['ticket_id']}}" :highlight="$ticket['status'] == 'open' ">
                    <h3>{{$ticket["ticket_id"]}} | {{$ticket['ticket_category']}} | {{ $ticket["ticket_title"]}} | {{$ticket['ticket_priority']}} | {{$ticket["ticket_status"]}}</h3>
                </x-card>
            </li>
        @endforeach
    </ul>
</x-dashboard>