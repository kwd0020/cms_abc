<x-dashboard>
    <h2> Current Users </h2>

    <ul>
        @foreach($users as $user)
            <li>
                <x-card href="/users/{{$user->user_id}}" :highlight="true">
                    <div>
                        <h3> 
                            {{$user->user_id}} | 
                            {{$user->user_name}} | 
                            {{$user->user_email}}  
                        </h3>
                        <p>{{ $user->role->role_name }}</p>
                            
                    </div>
                    
                </x-card>
            </li>
        @endforeach
    </ul>
    {{$users->links()}}
</x-dashboard>