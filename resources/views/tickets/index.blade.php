<x-dashboard>
    <h2> All Tickets </h2>

    @if($greeting == "hello")
        <p>Content within directive</p>
    @endif

    <ul>
        @foreach($tickets as $ticket)
            <li>
                <x-card href="/tickets/{{$ticket['ticket_id']}}" :highlight="$ticket['status'] == 'open' ">
                    <h3>{{ $ticket["title"]}} , {{$ticket["status"]}} , {{$ticket["ticket_id"]}}</h3>
                </x-card>
            </li>
        @endforeach
    </ul>
</x-dashboard>