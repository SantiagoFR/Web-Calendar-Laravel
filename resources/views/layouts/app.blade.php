<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Gestor de eventos</title>
    <link rel="shortcut icon" href="/images/ulpgc.png" type="image/png"/>

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
    <link href="{{ asset('css/carousel-vertical.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
</head>

<body>
@include('sweetalert::alert')

<div class="cabecera">
    <div class="container">
        <div class="logo"><a href="http://www.ulpgc.es"></a></div>
    </div>

</div>
<nav class="navbar navbar-expand-lg navbar-light bg-light" id="menu"
     style="color:#023265 !important;background-color:#fff !important">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
        <div class="row">
            <div id="interior_info_unidad" title="Inicio de la EII">
                <div class="logo_unidad "><a
                        href="https://www.eii.ulpgc.es/tb_university_ex/?q=frontpage"><span><strong>Escuela de<br>
                                    Ingeniería Informática</strong></span></a>

                </div>
                <div class="nombre_unidad">
                    <a href="https://www.eii.ulpgc.es/tb_university_ex/?q=frontpage"><strong>Escuela de<br>
                            Ingeniería Informática</strong></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav d-lg-flex align-items-center">
                    @if (Auth::check())
                        <li class="nav-item dropdown" style="margin-right:25px" data-toggle="tooltip"
                            data-placement="top" title="Inicio">
                            <a href="{{route('home')}}" class="nav-link main-menu">inicio</a>
                        </li>
                        @can('admin')
                            <li class="nav-item dropdown" style="margin-right:25px" data-toggle="tooltip"
                                data-placement="top" title="Administración de usuarios">
                                <a href="{{ route('users.index') }}" class="nav-link main-menu">admin</a>
                            </li>
                        @endcan
                        @canany(['profesor','administracion'])
                            <li class="nav-item dropdown" style="margin-right:25px" data-toggle="tooltip"
                                data-placement="top" title="Peticiones">
                                <a href="{{ route('peticions.index') }}" class="nav-link main-menu">peticiones</a>
                            </li>
                        @endcanany
                        <li class="nav-item dropdown" style="margin-right:25px" data-toggle="tooltip"
                            data-placement="top" title="Calendario de eventos">
                            <a href="{{ route('eventos.index') }}" class="nav-link main-menu">eventos</a>
                        </li>
                        <li class="nav-item" style="margin-right:25px" data-toggle="tooltip" data-placement="top"
                            title="Cerrar sesión">
                            <a class="nav-link main-menu" class="item" href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                logout
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
        </div>
    </div>
</nav>
<div id="sombra_separadora_portada"></div>
<br>
<div id="app">
    @yield('content')
</div>
<br><br>
<footer>
    <div id="pie_final">
        <div id="block-block-30" class="block block-block">
            <p class="rtecenter">
                    <span style="color:#FFFFFF;">Copyright © Escuela de Ingeniería Informática de la ULPGC. Todos los
                        derechos reservados.</span></p>

        </div> <!-- /.block -->
    </div>
</footer>
</body>

</html>
