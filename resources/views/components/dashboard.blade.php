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
           <a href="/tickets"> All Tickets</a>
           <a href="/users"> All Users </a>
           <a href="/tickets/create"> Create New Ticket </a>
        </nav>
    </header>

    <main class="container">
     {{$slot}}
    </main>
</body>
</html>