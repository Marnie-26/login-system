<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest Login System</title>
        <link rel="stylesheet" href="{{ asset('css/admin_login_style.css') }}">
    </head>
    <body>
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <form method="POST" action="{{ url('/admin-login') }}">
            @csrf
            <h3>Login</h3>
            @if(session('error'))
                <div style="margin-top: 15px">
                    <center>{{ session('error') }}</center>
                </div>
            @endif
            <label for="user_name">Username</label>
            <input type="text" id="user_name" name="user_name">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            <button type="submit">Log In</button>
        </form>
    </body>
</html>
