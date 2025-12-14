<x-dashboard>
    <h2> Ticket id - {{$ticket->ticket_id}}</h2>

    <div class="bg-gray-200 p-4 rounded">
        <p><strong>Company: {{$ticket->tenant->tenant_name}}</strong></p>
        <p><strong>Title: {{$ticket->ticket_title}}</strong> </p>
        <p><strong>Category:  </strong> {{$ticket->ticket_category}}</p>
        <p><strong>Description: </strong> {{$ticket->ticket_description}}</p>
        <p><strong>Owner: </strong> {{$ticket->user->user_name}} | ID: {{$ticket->user->user_id}}</p>
        <p><strong>Priority: </strong> {{$ticket->ticket_priority}}</p>
        <p><strong>Status: </strong> {{$ticket->ticket_status}}</p>
        <p><strong>Created At: </strong> {{$ticket->ticket_created_at}}</p>
        <p><strong>Last Updated: </strong> {{$ticket->ticket_updated_at}}</p>
    </div>

    <form action="{{ route('tickets.destroy', $ticket->ticket_id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn my-4">Delete Ticket </button>
    </form>
</x-dashboard>
    