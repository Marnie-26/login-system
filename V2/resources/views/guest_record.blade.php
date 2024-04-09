<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Guest Login System</title>
        <link rel="stylesheet" href="{{ asset('css/guest_login_style.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-body">
            <div class="container-fluid">
                <!-- Current Admin Logged In -->
                <span class="navbar-text">
                    @if(auth()->check())
                        Admin: {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                    @endif
                </span>
                <!-- Logout button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="row">
                <div class="col">
                    <h2>Visitor's Record Book</h2>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <a href="{{ route('guest.login') }}" class="btn btn-dark">Back</a>
                    <button type="submit" class="btn btn-dark">Export as Excel</button>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert" style="margin-top: 15px">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger" role="alert" style="margin-top: 15px">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row mt-3">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Purpose</th>
                                    <th>Date</th>
                                    <th>Time In</th>
                                    <th>Time Out</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guests as $guest)
                                <tr>
                                    <td>{{ $guest->first_name }}</td>
                                    <td>{{ $guest->middle_name }}</td>
                                    <td>{{ $guest->last_name }}</td>
                                    <td>{{ $guest->visit_purpose }}</td>
                                    <td>{{ $guest->visit_date }}</td>
                                    <td>{{ $guest->time_in }}</td>
                                    <td>{{ $guest->time_out }}</td>
                                    <td>
                                        <button type="button" class="btn btn-outline-primary">Edit</button>
                                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $guest->id }}">Delete</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
  
                        <!-- Delete Modal -->
                        @foreach($guests as $guest)
                        <div class="modal fade" id="deleteModal{{ $guest->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{ $guest->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="deleteModalLabel{{ $guest->id }}">Confirm Delete</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete visitor's record?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('delete.guest.record', $guest->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete Record</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
