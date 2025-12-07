<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System | Tickets</title>
</head>
<body>
    <h2> All Tickets </h2>

    @if($greeting == "hello")
        <p>Content within directive</p>
    @endif

    <ul>
        @foreach($tickets as $ticket)
            <li>
                <p> {{$ticket['title'] }} </p>
                <a href="/tickets/{{$ticket['ticket_id']}}">View Details</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
</html>