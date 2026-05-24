{{-- C:\Users\HP\Desktop\Lumiere\resources\views\admin\auth\login.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumière Admin Login</title>
</head>
<body>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
            @error('email')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="remember">
                <input id="remember" type="checkbox" name="remember" value="1">
                Remember me
            </label>
            @error('remember')
                <div>{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Log in</button>
    </form>
</body>
</html>
