<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    @vite('resources/css/app.css')
</head>
<body class="text-center px-8 py-12">
    <h1> ABC Limited Complaint Management System </h1>

    <a href="/tickets" class="btn mt-4 inline-block">
        Login
    </a>
</body>
</html>