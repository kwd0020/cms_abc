<x-dashboard>

    <h1> Update Ticket Details </h1>
    <div class="flex flex-col lg:flex-row gap-2 items-start"> 
        <div class="form-wrapper w-full lg:w-3/4">
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


                @can('update', $ticket)
                    <div class="text-center">
                        <button type="submit" class="btn mt-4">Update Ticket</button>
                    </div>
                @endcan
            
            </form>
        </div>

        <div class="form-wrapper w-full lg:w-1/4">
            <!----- User Assignment ----->
            @can('assign', $ticket)
                <div class="flex-1">
                    <form action="{{ route('tickets.assign', $ticket->ticket_id) }}" method="POST">
                        @csrf 
                        @method('PATCH')
                            <label>Assign Support Person/Agent</label>
                            <select name="assigned_user_id">
                                <option value="">Unassigned</option>
                                @foreach($supportUsers as $u)
                                <option value="{{ $u->user_id }}" @selected($ticket->assigned_user_id == $u->user_id)>
                                    {{ $u->user_name }}
                                </option>
                                @endforeach
                            </select>
                        <div class="text-centre">
                            <button type="submit" class="btn mt-4"> Assign </button>
                        </div>
                    </form>
                </div>
            @endcan
        </div>
    </div>
</x-dashboard>