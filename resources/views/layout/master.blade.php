<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Spotify Playlist Analyser</title>
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
</head>
<body>

<header class="navbar">
    <section class="navbar-section">
        <a href="{{ route('start') }}" class="green btn btn-link">Search</a>

    </section>
    <section class="navbar-section">
        <a href="" class="green btn btn-link">Statistics</a>
        <a href="" class="green btn btn-link">About</a>
    </section>
</header>

<main>
    @yield('content')
</main>

<footer class="navbar">
    <section class="navbar-section">
        <a href="" class="green btn btn-link">Legal notice</a>
        <a href="" class="green btn btn-link">Data privacy</a>
    </section>
    <section class="navbar-section">
        <p class="green btn btn-link">Copyright: 2020 - <?php echo date("Y");?></p>
    </section>
</footer>
</body>
</html>
