<x-dashboard>

    <form action="" method="">
    @csrf
        <h2>Login</h2>

        <label for="email">Email: </label>
        <input type="email" name="user_email" required value="{{ old('user_email') }}">

        <label for="password">Password: </label>
        <input type="password" name="password" id="password" >

        <button type="submit" class="btn mt-4">Log In</button>

    </form>
    
</x-dashboard>