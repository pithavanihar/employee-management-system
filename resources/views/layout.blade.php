<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Employee Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Employee Manager</a>
        <div>
            <a class="btn btn-outline-light btn-sm" href="{{ route('departments.index') }}">Departments</a>
            <a class="btn btn-outline-light btn-sm" href="{{ route('dashboard') }}">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-outline-warning btn-sm">Logout</button>
            </form>
        </div>
    </div>
</nav>
@if(session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger text-center">
        {{ session('error') }}
    </div>
@endif

<div class="container">
    @yield('content')
</div>

</body>
</html>
