<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <style>
        body { font-family: 'Instrument Sans', sans-serif; background: #fdfdfc; color: #1b1b18; }
        .container { max-width: 400px; margin: 100px auto; background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 8px #0001; }
        .logout-btn { background: #f53003; color: #fff; border: none; padding: 0.75rem 1.5rem; border-radius: 4px; font-weight: 600; cursor: pointer; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat datang di Dashboard!</h1>
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html> 