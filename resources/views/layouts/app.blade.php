<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('plugins/images/assets/favicon.ico') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('ample-admin/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{ asset('plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{ asset('plugins/bower_components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('ample-admin/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('ample-admin/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('ample-admin/css/colors/default.css') }}" id="theme" rel="stylesheet">
</head>

<body class="fix-header">
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="dashboard.html">
                        <!-- Logo icon image, you can use font-icon also -->
                        <b>
                            <!-- This is dark logo icon -->
                            <img src="{{ asset('plugins/images/admin-logo.png') }} " alt="home" class="dark-logo" />
                            <!--This is light logo icon -->
                            <img src="{{ asset('plugins/images/admin-logo-dark.png') }}" alt="home" class="light-logo" />
                        </b>
                        <!-- Logo text image you can use text also -->
                        <span class="hidden-xs">
                            <!-- This is dark logo text -->
                            <img src="{{ asset('plugins/images/admin-text.png') }}" alt="home" class="dark-logo" />
                            <!-- This is light logo text -->
                            <img src="{{ asset('plugins/images/admin-text-dark.png') }}" alt="home" class="light-logo" />
                        </span>
                    </a>
                </div>
                <!-- /Logo -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="nav-toggler open-close waves-effect waves-light hidden-md hidden-lg" href="javascript:void(0)"><i class="fa fa-bars"></i></a>
                    </li>
                    <li>
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control">
                            <a href="">
                                <i class="fa fa-search"></i>
                            </a>
                        </form>
                    </li>
                    <li>
                        <a class="profile-pic" href="#"> <img src="{{ (Auth::user()->photo != '') ? asset(Auth::user()->photo) : asset('plugins/images/users/no-avatar.png') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ Auth::user()->name }}</b></a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
                </div>
                <ul class="nav" id="side-menu">
                    <li style="padding: 70px 0 0;">
                        <a href="{{ route('home') }}" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>{{ __('menu.dashboard') }}</a>
                    </li>
                    @if (Auth::user()->admin == 1)
                    <li>
                        <a href="{{ route('invitations') }}" class="waves-effect"><i class="fa fa-link fa-fw" aria-hidden="true"></i>{{ __('menu.invitations') }}</a>
                    </li>
                    @endif
                    <li>
                        <a href="profile.html" class="waves-effect"><i class="fa fa-users fa-fw" aria-hidden="true"></i>{{ __('menu.students') }}</a>
                    </li>
                    <li>
                        <a href="profile.html" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>{{ __('menu.teachers') }}</a>
                    </li>
                    <li>
                        <a href="basic-table.html" class="waves-effect"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i>{{ __('menu.calendars') }}</a>
                    </li>
                    <li>
                        <a href="fontawesome.html" class="waves-effect"><i class="fa fa-font fa-fw" aria-hidden="true"></i>{{ __('menu.grades') }}</a>
                    </li>
                    <li>
                        <a href="map-google.html" class="waves-effect"><i class="fa fa-bookmark fa-fw" aria-hidden="true"></i>{{ __('menu.classes') }}</a>
                    </li>
                    <li>
                        <a href="blank.html" class="waves-effect"><i class="fa fa-book fa-fw" aria-hidden="true"></i>{{ __('menu.subjects') }}</a>
                    </li>
                    <li>
                        <a href="404.html" class="waves-effect"><i class="fa fa-cogs fa-fw" aria-hidden="true"></i>{{ __('menu.configuration') }}</a>
                    </li>

                </ul>
                <!-- <div class="center p-20">
                     <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger btn-block waves-effect waves-light">Upgrade to Pro</a>
                </div> -->
            </div>

        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            <input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
            <input type="hidden" id="hasError" value="{{ session()->has('error') }}">
            <input type="hidden" id="success" value="{{ session('success') }}">
            <input type="hidden" id="error" value="{{ session('error') }}">
            <div class="container-fluid">
                @yield('content')
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center"> 2017 &copy; Ample Admin brought to you by wrappixel.com </footer>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('ample-admin/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('ample-admin/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('ample-admin/js/waves.js') }}"></script>
    <!--Counter js -->
    <script src="{{ asset('plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!-- chartist chart -->
    <script src="{{ asset('plugins/bower_components/chartist-js/dist/chartist.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="{{ asset('plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('ample-admin/js/custom.min.js') }}"></script>
    <script src="{{ asset('ample-admin/js/dashboard1.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
    <script>
        $(document).ready(function() {
            const hasSuccess = document.getElementById('hasSuccess').value;
            const success = document.getElementById('success').value;
            if (hasSuccess) {
                $.toast({
                    heading: 'Open Grades',
                    text: success,
                    position: 'top-right',
                    loaderBg: '#fff',
                    icon: 'success',
                    hideAfter: 5000,
                    stack: 6
                });
            }

            const hasError = document.getElementById('hasError').value;
            const error = document.getElementById('error').value;
            if (hasError) {
                $.toast({
                    heading: 'Open Grades',
                    text: error,
                    position: 'top-right',
                    icon: 'error',
                    hideAfter: 5000,
                    stack: 6
                });
            }
        });
    </script>
</body>

</html>