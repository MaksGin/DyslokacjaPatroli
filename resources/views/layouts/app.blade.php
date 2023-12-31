<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery.js') }}" defer></script>



    <link href="{{ asset('css/jqueryUI.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="{{ asset('fonts/googleFonts.css') }}" rel="stylesheet">

    <!-- Styles CSS -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel = "stylesheet" href= "{{ URL::asset('css/bootstrap.min.css')}}">
    <link rel = "stylesheet" href= "{{ URL::asset('css/fontAwasome.min.css')}}">
    <link href="{{ asset('fontAwasome/css/all.min.css') }}" rel="stylesheet">







</head>
<body>

    <div id="app">
        <!-- nawigacja -->
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
            @auth
                <a class="navbar-brand" href="{{ url('/main') }}">
                    Dyslokacja Patroli
                </a>
            @endauth
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto"></ul>


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest

                        @else
                        @auth

                        <li><a class="nav-link" href="{{ route('main') }}">Patrole</a></li>

                            @role('Koordynator|Admin|Komendant')
                                <li><a class="nav-link" href="{{ route('allPatrols.index') }}">Lista patroli</a></li>
                                <li><a class="nav-link" href="{{ route('showSklady') }}">Kryptonimy</a></li>
                                <li><a class="nav-link" href="{{ route('rejony.index') }}">Rejony</a></li>
                            @endrole
                        @endauth

                        @can('wydzial-list')
                            <li><a class="nav-link" href="{{ route('wydzial.index') }}">Wydziały</a></li>

                        @endcan

                        @can('user-list')
                            <li><a class="nav-link" href="{{ route('users.index') }}">Użytkownicy</a></li>
                            <li><a class="nav-link" href="{{ route('roles.index') }}">Role</a></li>

                        @endcan
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>


                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Wyloguj') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>


        <main class="py-4">
            <div class="container">
            @yield('content')
            </div>
        </main>
    </div>




</body>
</html>
