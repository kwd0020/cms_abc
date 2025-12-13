<x-dashboard>
    <h2> User id - {{$user->user_id}}</h2>

    <div class="bg-gray-200 p-4 rounded">
        <p><strong>Name: </strong> {{$user->user_name}}</p>
        <p><strong>Email:  </strong> {{$user->user_email}}</p>
        <p><strong>Phone Number: </strong> {{$user->phone_number}}</p>
        <p><strong>Role ID: </strong> {{$user->role_id}}</p>

    </div>

</x-dashboard>