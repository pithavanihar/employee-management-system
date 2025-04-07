<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4">Login</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('loginForm') }}">
        @csrf

        <div class="mb-3">
            <label>Email address</label>
            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required>
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox"
                   name="remember"
                   class="form-check-input"
                   id="remember"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">Remember Me</label>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>
</body>
</html>
