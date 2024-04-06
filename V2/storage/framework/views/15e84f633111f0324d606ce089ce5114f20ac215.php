<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Guest Login System - Practice</title>
        <link rel="stylesheet" href="<?php echo e(asset('css/guest_login_style.css')); ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar bg-dark border-bottom border-body">
            <div class="container-fluid">
                <!-- Navbar brand/logo -->
                <a></a>
                <!-- <a class="navbar-brand" href="#">Your Logo</a> -->
        
                <!-- Logout button -->
                <button class="btn btn-outline-light" onclick="logout()">Logout</button>
            </div>
        </nav>
        <div style="margin: 50px; border-radius: 10px;">
            <div style="margin-bottom: 25px">
                <h2>Welcome!</h2>
            </div>
    
            <div style="display: flex; flex-direction: column;">
                <table style="border-radius: 10px; margin-bottom: 20px;">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Image</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John</td>
                            <td>Doe</td>
                            <td><img src="https://t3.ftcdn.net/jpg/06/02/18/62/360_F_602186218_fpYxVU19SUIV1IFYU6g144NBh28dWeFY.jpg" alt="Guest Image" style="width: 100px; height: 100px; border-radius: 10px;"></td>
                            <td>08:00 AM</td>
                            <td>05:00 PM</td>
                            <td>
                                <button type="button" class="btn btn-outline-success">View</button>
                                <button type="button" class="btn btn-outline-primary">Edit</button>
                                <button type="button" class="btn btn-outline-danger">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div style="align-self: flex-end;">
                    <button type="submit">Add New Visitor</button>
                </div>
            </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    </body>
</html>
<?php /**PATH C:\Users\Dell\Downloads\login-system-local\V2\resources\views/guest_login.blade.php ENDPATH**/ ?>