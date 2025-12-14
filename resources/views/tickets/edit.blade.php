<x-dashboard>

    <h1> Update Ticket Details </h1>

    <form action="{{ route('tickets.update', $ticket->ticket_id) }}" method="POST">
        @csrf
        @method('PUT')
        <!--Validation Errors -->
        @if ($errors->any())
            <div>
                <ul class="px-4 py-2 bg-red-100">
                    @foreach ($errors->all() as $message)
                        <li class="my-2 text-red-500"> {{ $message }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <h2>Ticket ID - {{$ticket->ticket_id}}</h2>
        <!--Title-->
        <label for="ticket_title">Ticket Title:</label>
        <input type="text" id="ticket_title" name="ticket_title" value="{{old('ticket_title', $ticket->ticket_title)}}" required>

        <!--Tenant-->
        <label for="ticket_tenant">Company</label>
        <select name="ticket_tenant" id="ticket_tenant">
            <option value="" disabled selected>Select a Company</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->tenant_id }}" {{ (int) old('ticket_tenant', $tenant->tenant_id) == (int) $tenant->tenant_id ? 'selected' : '' }}>
                    {{$tenant->tenant_name }}
                </option>
            @endforeach
        </select>

        <!--User NEEDS REMOVING AFTER LOGIN FUNCTIONALITY-->
        <label for="ticket_user">Owner</label>
        <select name="ticket_user" id="ticket_user" required>
            <option value=""disabled selected>Assign A User</option>
            @foreach ($users as $user)
                <option value="{{ $user->user_id }}" {{ (int) old('ticket_user', $user->user_id) == (int) $user->user_id ? 'selected' : '' }}>
                    {{$user->user_id }} | {{$user->user_name}} | {{$user->tenant_id}}
                </option>
            @endforeach
        </select>
            

        <!--Category-->
        <label for="ticket_category">Category</label>
        <select name="ticket_category" id="ticket_category" required>
            <option value="" disabled selected>Select a Category</option>
            @foreach ($categories as $category)
                <option value="{{ $category }}" {{old('ticket_category', $ticket->ticket_category) == $category ? 'selected' : '' }}>
                    {{$category }}
                </option>
            @endforeach
        </select>

        <!--Description-->
        <label for="ticket_description">Description</label>
        <textarea rows="5" id="ticket_description" name="ticket_description"  required>{{old('ticket_description', $ticket->ticket_description) }}</textarea>

        <!--Priority-->
        <label for="ticket_priority">Priority</label>
        <select name="ticket_priority" id="ticket_priority" required>
            <option value="" disabled selected>Select a Priority</option>
            @foreach ($priorities as $priority)
                <option value="{{ $priority }}" {{old('ticket_priority', $ticket->ticket_priority) == $priority ? 'selected' : '' }}>
                    {{$priority }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn mt-4">Update Ticket</button>
    
    </form>

</x-dashboard>