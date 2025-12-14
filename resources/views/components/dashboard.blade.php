<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    @vite('resources/css/app.css')
</head>
<body>

    
    <header>
        <nav>
           <h1>ABC Limited</h1>
           <a href="{{ route('tickets.index') }}"> All Tickets</a>
           <a href="{{ route('users.index') }}"> All Users </a>
           <a href="/tickets/create"> Create New Ticket </a>
        </nav>
    </header>
    
    @if (session('success'))
        <div id="flash" class="p-4 text-center bg-green-50 text-green-500 font-bold">
            {{ session('success') }}
        </div>
    @endif

    <main class="container">
     {{$slot}}
    </main>
</body>
</html>