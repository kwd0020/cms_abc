<x-dashboard>
    <h2> User id - {{$user->user_id}}</h2>

    <div class="bg-gray-200 p-4 rounded">
        <p><strong>Name: </strong> {{$user->user_name}}</p>
        <p><strong>Email:  </strong> {{$user->user_email}}</p>
        <p><strong>Phone Number: </strong> {{$user->phone_number}}</p>
        <p><strong>Role: </strong> {{$user->role->role_name}}</p>
        <p><strong>Company: </strong> {{$user->tenant->tenant_name}} </p>

    </div>

</x-dashboard>