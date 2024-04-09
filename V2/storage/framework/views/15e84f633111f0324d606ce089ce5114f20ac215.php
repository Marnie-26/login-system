<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Guest Login System</title>
        <link rel="stylesheet" href="<?php echo e(asset('css/guest_login_style.css')); ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-body">
            <div class="container-fluid">
                <!-- Current Admin Logged In -->
                <span class="navbar-text">
                    <?php if(auth()->check()): ?>
                        Admin: <?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?>

                    <?php endif; ?>
                </span>
                <!-- Logout button -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <h2>Welcome to the Regency at Salcedo!</h2>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <a href="<?php echo e(route('visit.guest.record')); ?>" class="btn btn-dark">View All Records</a>
                </div>
            </div>
            
            <?php if(session('success')): ?>
                <div class="alert alert-success" role="alert" style="margin-top: 15px">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>
            
            <?php if(session('error')): ?>
                <div class="alert alert-danger" role="alert" style="margin-top: 15px">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="col">
                    <div class="table-responsive">
                        <form action="<?php echo e(route('guests.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Purpose</th>
                                        <th>Date</th>
                                        <th>Time In</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="first_name" class="form-control" placeholder="Enter First Name" required></td>
                                        <td><input type="text" name="middle_name" class="form-control" placeholder="Enter Middle Name"></td>
                                        <td><input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" required></td>
                                        <td><input type="text" name="visit_purpose" class="form-control" placeholder="Enter Visiting Purpose" required></td>
                                        <td><input type="date" name="visit_date" class="form-control" id="visitDate" required></td>
                                        <td><input type="time" name="time_in" class="form-control" id="timeIn" required></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col text-end">
                                <button type="submit" class="btn btn-dark">Add New Visitor</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
<?php /**PATH C:\Users\Dell\Downloads\login-system-local\V2\resources\views/guest_login.blade.php ENDPATH**/ ?>