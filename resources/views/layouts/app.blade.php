<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/extra.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    <div id="app">
            <div style="background-color:#241654">
                <a href="{{ route('home') }}"><img src="{{ asset('images/logo2.png') }}" style="height:100px"></a>
            </div>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            @if (Auth::check())
                            <li class="nav-item navbar-brand">
                                <a class="nav-link" href="{{ route('home') }}">Inicio </a>
                            </li>
                            <li class="nav-item navbar-brand">
                                <a class="nav-link" href="{{ route('users.index') }}">Admin</a>
                            </li>
                            <li class="nav-item navbar-brand" data-toggle="tooltip" data-placement="top"
                                title="Cerrar sesión">
                                <a class="nav-link" class="item" href="#" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </li>
                            @else
                            <li class="nav-item navbar-brand">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                            <li class="nav-item navbar-brand">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                            @endif
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
            <br>
        @yield('content')
    </div>
</body>

</html>