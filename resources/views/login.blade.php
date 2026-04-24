<form method="POST" action="/login">
    @csrf

    <input type="email" name="email" placeholder="Email">
    <input type="password" name="password" placeholder="Password">

    <button type="submit">LOGIN</button>
</form>

@if(session('error'))
    <p style="color:red">{{ session('error') }}</p>
@endif