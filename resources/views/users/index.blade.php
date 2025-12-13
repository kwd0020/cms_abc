<x-dashboard>
    <h2> Current Users </h2>

    <ul>
        @foreach($users as $user)
            <li>
                <x-card href="/users/{{$user->user_id}}" :highlight="true">
                    <h3> {{$user->user_id}} | 
                    {{$user->user_name}} | 
                    {{$user->role_id}} | 
                    {{$user->user_email}} </h3>
                </x-card>
            </li>
        @endforeach
    </ul>

</x-dashboard>