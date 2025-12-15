<x-dashboard>

    <div class="form-wrapper">
        <form action="login" method="POST">
            @csrf
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
            <h2>Login</h2>

            <label for="email">Email: </label>
            <input type="email" name="user_email" required value="{{ old('user_email') }}">

            <label for="password">Password: </label>
            <input type="password" name="password" id="password" >

            <div class="text-center">
                <button type="submit" class="btn mt-4">Log In</button>
            </div>
            

    </form>
    </div>
    
    
</x-dashboard>