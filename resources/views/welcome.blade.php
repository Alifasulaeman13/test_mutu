<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background: #f8fafc; color: #222; }
        .container { max-width: 400px; margin: 100px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
        .title { font-size: 2rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center; }
        .input-group { margin-bottom: 1.25rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        input[type="text"], input[type="password"] { width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px; font-size: 1rem; }
        .btn { width: 100%; background: #f53003; color: #fff; border: none; padding: 0.75rem; border-radius: 4px; font-weight: 600; font-size: 1rem; cursor: pointer; transition: background 0.2s; }
        .btn:hover { background: #c41e00; }
        .error { color: #e3342f; margin-bottom: 1rem; text-align: center; }
        .success { color: #38a169; margin-bottom: 1rem; text-align: center; }
        .dashboard-link { display: block; margin-top: 2rem; text-align: center; }
        .logout-btn { background: #888; margin-top: 1rem; }
    </style>
</head>
<body>
    <div class="container">
        @if (isset($showLogin) && $showLogin)
            <form method="POST" action="/login">
                @csrf
                <div class="title">Login Admin</div>
                @if (session('error'))
                    <div class="error">{{ session('error') }}</div>
                @endif
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" required autofocus>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
        @else
            @php $isLoggedIn = session('is_logged_in'); @endphp
            @if ($isLoggedIn)
                <div class="title">Selamat datang, Admin!</div>
                <div class="success">Anda sudah login.</div>
                <a href="/dashboard" class="btn dashboard-link">Ke Dashboard</a>
                <form method="POST" action="/logout">
                    @csrf
                    <button type="submit" class="btn logout-btn">Logout</button>
                </form>
            @else
                <div class="title">Login Admin</div>
                <a href="/login" class="btn">Login</a>
            @endif
        @endif
    </div>
</body>
</html>
