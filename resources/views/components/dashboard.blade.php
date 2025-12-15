<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    @vite('resources/css/app.css')
</head>
<body>

    
    <header>
        <nav class="mx-auto flex items-center justify-between px-6 py-3">
            <a href="{{route('tickets.index')}}"><h1>ABC Limited</h1></a>
            
            <div class="flex items-center gap-4">
                @guest
                    <a href="{{ route('show.register') }}" class="btn">Register </a>
                    <a href="{{ route('show.login') }}" class="btn">Login </a>
                @endguest

                <!--Only show when authenticated-->
                @auth
                    <a href="{{ route('tickets.index') }}"> All Tickets</a>
                    <a href="{{ route('users.index') }}"> All Users </a>
                    <a href="/tickets/create"> Create New Ticket </a>
                    
                    <span class="border-r-2 pr-2">
                        Welcome, {{ Auth::user()->user_name }}
                    </span>
                    <form action="{{route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button class="btn">Logout</button>
                    </form>
                @endauth
            </div>
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