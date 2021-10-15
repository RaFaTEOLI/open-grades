<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('css/icons/font-awesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons/font-awesome/css/brands.css') }}" rel="stylesheet">
    <link href="{{ asset('css/icons/font-awesome/css/solid.css') }}" rel="stylesheet">
    <!-- Material Design -->
    <link href="{{ asset('css/icons/material-design-iconic-font/css/materialdesignicons.min.css') }}" rel="stylesheet">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Main wrapper -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Header part -->
        <!-- ============================================================== -->
        <header class="py-3 bg-white">
            <div class="container">
                <!-- Start Header -->
                <div class="header">
                    <nav class="navbar navbar-expand-md navbar-light px-0">
                        <a class="navbar-brand" href="#">
                            <i class="fas fa-book"></i>
                            <span>
                                {{ config('app.name', 'Laravel') }}
                            </span>
                        </a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                <!-- Authentication Links -->
                                @guest
                                <li class="nav-item pr-3">
                                    <a href="{{ route('login') }}" class="btn btn-custom btn-outline-info btn-lg">{{ __('login_register.login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                <li class="nav-item pr-3">
                                    <a href="{{ route('register') }}" class="btn btn-custom btn-outline-info btn-lg">{{ __('login_register.register') }}</a>
                                </li>
                                @endif
                                @else
                                <li class="nav-item pr-3">
                                    <a href="{{ route('language', (app()->getLocale() === 'en') ? 'pt' : 'en') }}" class="btn btn-custom btn-outline-info btn-lg"><img height="20px" width="20px" style="border-radius: 10px;" src="{{ asset("plugins/images/flags/" . app()->getLocale(). ".png") }} " alt="{{ app()->getLocale() }}" /></a>
                                </li>
                                <li class="nav-item pr-3">
                                    <a href="{{ route('home') }}" class="btn btn-custom btn-outline-info btn-lg">{{ __('menu.dashboard') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
                </div>
                <!-- End Header -->
            </div>
        </header>
        <!-- ============================================================== -->
        <!-- Header part -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Page wrapper part -->
        <!-- ============================================================== -->
        <div class="content-wrapper">
            <!-- ============================================================== -->
            <!-- Demos part -->
            <!-- ============================================================== -->
            <section class="spacer bg-light">
                <div class="container">
                    @yield('content')
                </div>
            </section>
        </div>
        <!-- ============================================================== -->
        <!-- End page wrapperHeader part -->
        <!-- ============================================================== -->
        <footer class="text-center p-4"> All Rights Reserved by Open Grades. Template by <a href="https://wrappixel.com">WrapPixel</a>.</footer>
    </div>
</body>
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>

</html>
