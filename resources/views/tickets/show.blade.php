<x-dashboard>
    
    <div class="flex justify-between items-center mb-4">
       <h2> Ticket id - {{$ticket->ticket_id}}</h2>

        @can('update', $ticket)
            <a href="{{ route('tickets.edit', $ticket->ticket_id) }}" class="btn">Edit</a>
        @endcan
        </div>
    <div class="bg-gray-200 p-4 rounded">
        <p><strong>Company: {{$ticket->tenant->tenant_name}}</strong></p>
        <p><strong>Title: {{$ticket->ticket_title}}</strong> </p>
        <p><strong>Category:  </strong> {{$ticket->ticket_category}}</p>
        <p><strong>Description: </strong> {{$ticket->ticket_description}}</p>
        <p><strong>Owner: </strong> {{$ticket->user->user_name}} | ID: {{$ticket->user->user_id}}</p>
        <p><strong>Assigned To: </strong> {{$ticket->assignee->user_name ?? 'Unassigned'}} | Email: {{$ticket->assignee->user_email ?? 'Unassigned'}}</p>
        <p><strong>Priority: </strong> {{$ticket->ticket_priority}}</p>
        <p><strong>Status: </strong> {{$ticket->ticket_status}}</p>
        <p><strong>Created At: </strong> {{$ticket->ticket_created_at}}</p>
        <p><strong>Last Updated: </strong> {{$ticket->ticket_updated_at}}</p>
        <h3 class="mt-4 font-bold">Timeline</h3>
        <!-- Ticket History Information -->
        @forelse($ticket->history as $h)
        <div class="border-b py-2">
            <div>
                <strong>{{ $h->created_at }}</strong>
                    ({{ optional($h->changedBy)->user_name ?? 'System' }})
                </div>
                @if($h->ticket_comment)
                    <div>Comment: {{ $h->ticket_comment }}</div>
                @endif
                @if($h->resolution_note)
                    <div>Resolution: {{ $h->resolution_note }}</div>
                @endif
                @if($h->from_status || $h->to_status)
                    <div>Status: {{ $h->from_status }} → {{ $h->to_status }}</div>
            @endif
        </div>
        @empty
        <p>No history yet.</p>
        @endforelse
    </div>

    @can('updateStatus', $ticket)
        <form action="{{ route('tickets.status', $ticket->ticket_id) }}" method="POST" class="mt-6 bg-white p-4 rounded">
            @csrf
            @method('PATCH')

            <!--Status-->
            <label class="block mb-2 font-bold">Change Status</label>
            <select name="ticket_status" class="border p-2 w-full">
                @foreach (['OPEN','IN_PROGRESS','RESOLVED','CLOSED'] as $st)
                    <option value="{{ $st }}" @selected($ticket->ticket_status === $st)>{{ $st }}</option>
                @endforeach
            </select>

            <!--Comment-->
            <label class="block mt-4 mb-2 font-bold">Comment (optional)</label>
            <textarea name="ticket_comment" class="border p-2 w-full" rows="3">{{ old('ticket_comment') }}</textarea>
           
            <!--Reoslution Note-->
            <label class="block mt-4 mb-2 font-bold">Resolution note (Required for CLOSED / RESOLVED)</label>
            <textarea name="resolution_note" class="border p-2 w-full" rows="3">{{ old('resolution_note') }}</textarea>

            <button type="submit" class="btn mt-4">Update Status</button>
        </form>
    @endcan

    <form action="{{ route('tickets.destroy', $ticket->ticket_id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn my-4">Delete Ticket </button>
    </form>

</x-dashboard>
    