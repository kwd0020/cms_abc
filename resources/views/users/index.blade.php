<x-dashboard>
    <h2> Current Users </h2>
    <p> {{$greeting}} </p>

    <ul>
        @foreach($users as $user)
            <li>
                <x-card href="/users/{{$user['user_id']}}" :highlight="true">
                    <h3>{{ $user["name"]}} , {{$user["role"]}} , {{$user["user_id"]}}</h3>
                </x-card>
            </li>
        @endforeach
    </ul>

</x-dashboard>