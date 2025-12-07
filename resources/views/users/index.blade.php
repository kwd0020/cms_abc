<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System | Users</title>
</head>
<body>
    <h2> Current Users </h2>
    <p> {{$greeting}} </p>

    <ul>
        <li>
            <a href="/users/{{$users[0]["user_id"]}}">
                {{ $users[0]["name"]}}
            </a>
        </li>
        <li>
            <a href="/users/{{$users[0]["user_id"]}}">
                {{ $users[1]["name"]}}
            </a>
        </li>
    </ul>
</body>
</html>