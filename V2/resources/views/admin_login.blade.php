<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>The Regency at Salcedo Visitor's Log</title>
        <link rel="stylesheet" href="{{ asset('css/admin_login_style.css') }}">
        <script src="https://kit.fontawesome.com/16f4fda31b.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="background-image">
            <div class="overlay"></div>
            <div class="container">
                <form method="POST" action="{{ url('/admin-login') }}">
                    @csrf
                    <h3>The Regency at Salcedo</h3>
                    <h3>Visitor's Log</h3>
                    @if(session('error'))
                        <div id="error-message" class="error-message">{{ session('error') }}</div>
                    @endif
                    <label for="user_name"><i class="fa-solid fa-user"></i> Username</label>
                    <input type="text" id="user_name" name="user_name">
                    <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password">
                    <button type="submit">Log In <i class="fa-solid fa-right-to-bracket"></i></button>
                </form>
            </div>
        </div>
        

        <script>
            // Hide alert
            function hideErrorMessage() {
                var errorMessage = document.getElementById('error-message');
                if (errorMessage) {
                    setTimeout(function() {
                        errorMessage.style.display = 'none';
                    }, 2000);
                }
            }
        
            window.onload = function() {
                hideErrorMessage();
        
                setTimeout(function() {
                    var errorMessage = document.getElementById('error-message');
                    if (errorMessage) {
                        errorMessage.style.display = 'none';
                    }
                }, 2000);
            };
        </script>
        
    </body>
</html>
