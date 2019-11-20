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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/extra.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')

    <div class="container">
        <div style="background-color:#241654">
            <a href="{{ route('home') }}"><img src="{{ asset('images/logo3.png') }}" style="height:100px"></a>
        </div>
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" id="menu" style="color:#fff !important">

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav d-lg-flex align-items-center">

                    @if (Auth::check())
                    <li class="nav-item dropdown" style="font-size:25px" data-toggle="tooltip" data-placement="top"
                        title="Inicio">
                        <a href="{{route('home')}}" class="nav-link">Inicio</a>
                    </li>
                    <li class="nav-item dropdown" style="font-size:25px" data-toggle="tooltip" data-placement="top"
                        title="Inicio">
                        <a href="{{ route('users.index') }}" class="nav-link">Admin</a>
                    </li>
                    <li class="nav-item dropdown" style="font-size:25px" data-toggle="tooltip" data-placement="top"
                        title="Inicio">
                        <a href="{{ route('eventos.index') }}" class="nav-link">Eventos</a>
                    </li>
                    <li class="nav-item" style="font-size:25px" data-toggle="tooltip" data-placement="top"
                        title="Cerrar sesión">
                        <a class="nav-link" class="item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
        </nav>
    </div>
    <br>
    <div id="app">
        @yield('content')
    </div>
    <br>
    <hr>
    <br>
</body>

</html>