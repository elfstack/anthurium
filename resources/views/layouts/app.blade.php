<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Anthurium') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Anthurium') }}
                </a>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a role="button" class="dropdown-toggle nav-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    @if(Auth::check() && Auth::user()->avatar_thumb_url)
                                        <img src="{{ Auth::user()->avatar_thumb_url }}" class="avatar-photo">
                                    @elseif(Auth::check() && Auth::user()->name)
                                        <span class="avatar-initials">{{ mb_substr(Auth::user()->name, 0, 1) }}</span>
                                    @elseif(Auth::guard(config('admin-auth.defaults.guard'))->check() && Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name && Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name)
                                        <span class="avatar-initials">{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->first_name, 0, 1) }}{{ mb_substr(Auth::guard(config('admin-auth.defaults.guard'))->user()->last_name, 0, 1) }}</span>
                                    @else
                                        <span class="avatar-initials"><i class="fa fa-user"></i></span>
                                    @endif

                                        <span class="d-none d-md-inline-block">{{ Auth::user()->name }}</span>

                                </span>
                                <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right position-absolute p-0">
                                <a class="dropdown-item" href="{{ route('profile') }}">{{ __('Profile') }}</a>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
            </div>
        </nav>

        <main class="my-3">
            <div class="modals">
                <v-dialog/>
            </div>
            <div>
                <notifications position="bottom right" :duration="2000" />
            </div>
            @yield('content')
        </main>

        <footer class="app-footer">
          <div>
            <span>&copy; 2020 {{ config('app.name', 'Anthurium') }}</span>
          </div>
          <div class="ml-auto">
            <span>Powered by</span>
            <a href="https://anthurium.elfstack.com/cms">Anthurium</a>
          </div>
        </footer>
    </div>
</body>
</html>
