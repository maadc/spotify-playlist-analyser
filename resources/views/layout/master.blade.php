<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Classify – spotify playlist analyser</title>
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
</head>
<body class="container">

<header>
    <nav class="">
        <div class="navbar col-sm-10 col-md-10 col-8 col-mx-auto">
            <section class="navbar-section">
                <span id="title" class="green">Classify</span>

                <div class="dropdown show-md">
                    <a href="#" class="btn btn-link dropdown-toggle" tabindex="0">
                        <img alt="dropdown menu" src="../../images/menu.svg">
                    </a>
                    <ul class="menu">
                        <li>
                            <a href="{{ route('start') }}" class="btn btn-link">Search</a>
                            <a href="{{ route('statistics') }}" class="btn btn-link">Statistics</a>
                            <a href="" class="btn btn-link">About</a>
                        </li>
                    </ul>
                </div>
                <div class="hide-md">
                    <a href="{{ route('start') }}" class="btn btn-link">Search</a>
                    <a href="{{ route('statistics') }}" class="btn btn-link">Statistics</a>
                    <a href="" class="btn btn-link">About</a>
                </div>
            </section>
        </div>
    </nav>
</header>

<main class="col-sm-12 col-md-10 col-8 col-mx-auto">
    <div id="app">
        @yield('content')
    </div>
</main>

<footer class="">
    <div class="navbar col-sm-12 col-md-10 col-8 col-mx-auto">
        <section class="navbar-section">
            <a href="" class="green btn btn-link">Legal notice</a>
            <a href="" class="green btn btn-link">Data privacy</a>
        </section>
        <section class="navbar-section">
            <span id="social-links">
                <a target="_blank" href="https://github.com/maadc/classify">
                    <img alt="github icon" src="../../images/github.svg" title="link to github">
                </a>
            </span>
            <span id="copyright">
                "class="green">Copyright: 2020 - <?php echo date("Y");?>
            </span>
        </section>
    </div>
</footer>
<script src="{{URL::asset('js/app.js')}}"></script>
</body>
</html>
