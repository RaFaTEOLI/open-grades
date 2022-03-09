<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('plugins/images/assets/favicon.ico') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

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
    <!-- Datatable CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.css">
</head>
<style>
    p.label-error>strong{color: tomato;}
    .loader {
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

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
                    <a class="logo" href="#">
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
                    <li style="display: none;">
                        <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" placeholder="Search..." class="form-control">
                            <a href="">
                                <i class="fa fa-search"></i>
                            </a>
                        </form>
                    </li>
                    <li class="nav-item dropdown dropdown-notifications">
                        <a href="#notifications-panel" class="dropdown-toggle" data-toggle="dropdown">
                            <i data-count="0" class="glyphicon glyphicon-bell notification-icon">
                              <span class="badge badge-warning notif-count text-right" id="notification-count" style="font-family: 'Rubik', sans-serif;">0</span>
                            </i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            {{-- <div class="dropdown-toolbar-actions">
                                <a href="#">Mark all as read</a>
                            </div> --}}
                            <div class="notifications-container">
                            </div>
                            {{-- <div class="dropdown-footer text-center">
                                <a href="#">View All</a>
                            </div> --}}
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="profile-pic nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> <img src="{{ (Auth::user()->photo != '') ? asset(Auth::user()->photo) : asset('plugins/images/users/no-avatar.png') }}" alt="user-img" width="36" class="img-circle"><b class="hidden-xs">{{ Auth::user()->name }}</b></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item btn" href="{{ route('logout') }}" onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                            </a>

                            <a class="dropdown-item btn" href="{{ route('users.profile') }}">
                                <i class="fa fa-user"></i> {{ __('My Profile') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
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
                    @if (Auth::user()->hasRole("admin"))
                    <li>
                        <a href="{{ route('users') }}" class="waves-effect"><i class="fa fa-users fa-fw" aria-hidden="true"></i>{{ __('menu.users') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('roles') }}" class="waves-effect"><i class="fa fa-shield fa-fw" aria-hidden="true"></i>{{ __('menu.roles') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('permissions') }}" class="waves-effect"><i class="fa fa-lock fa-fw" aria-hidden="true"></i>{{ __('menu.permissions') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('configuration') }}" class="waves-effect"><i class="fa fa-wrench fa-fw" aria-hidden="true"></i>{{ __('menu.configuration') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('invitations') }}" class="waves-effect"><i class="fa fa-link fa-fw" aria-hidden="true"></i>{{ __('menu.invitations') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('subjects') }}" class="waves-effect"><i class="fa fa-book fa-fw" aria-hidden="true"></i>{{ __('menu.subjects') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('years') }}" class="waves-effect"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i>{{ __('menu.years') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('grades') }}" class="waves-effect"><i class="fa fa-graduation-cap fa-fw" aria-hidden="true"></i>{{ __('menu.grades') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('statements') }}" class="waves-effect"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>{{ __('menu.statements') }}</a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('classes') }}" class="waves-effect"><i class="fa fa-bookmark fa-fw" aria-hidden="true"></i>{{ __('menu.classes') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('warnings') }}" class="waves-effect"><i class="fa fa-warning fa-fw" aria-hidden="true"></i>{{ __('menu.warnings') }}</a>
                    </li>
                    @if (Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher"))
                    <li>
                        <a href="{{ route('evaluation-types') }}" class="waves-effect"><i class="fa fa-quote-right fa-fw" aria-hidden="true"></i>{{ __('menu.evaluation_types') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('teachers') }}" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>{{ __('menu.teachers') }}</a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole('teacher'))
                    <li>
                        <a href="{{ route('grades') }}" class="waves-effect"><i class="fa fa-graduation-cap fa-fw" aria-hidden="true"></i>{{ __('menu.grades') }}</a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole("admin") || Auth::user()->hasRole("teacher") || Auth::user()->hasRole("responsible"))
                    <li>
                        <a href="{{ route('students') }}" class="waves-effect"><i class="fa fa-users fa-fw" aria-hidden="true"></i>{{ __('menu.students') }}</a>
                    </li>
                    @endif
                    @if (Auth::user()->hasRole("student"))
                    <li>
                        <a href="{{ route('student.classes') }}" class="waves-effect"><i class="fa fa-bookmark fa-fw" aria-hidden="true"></i>{{ __('menu.my_classes') }}</a>
                    </li>
                    @endif
                    <li>
                        <a href="basic-table.html" class="waves-effect"><i class="fa fa-calendar fa-fw" aria-hidden="true"></i>{{ __('menu.calendars') }}</a>
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
        <footer class="footer text-center"> {{ date('Y') }} &copy; Open Grades </footer>
    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Begin Modal -->
    <!-- ============================================================== -->
    <div class="modal fade" id="loading-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('actions.loading') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            <div class="modal-body" style="display: flex; justify-content: center;">
                <div class="loader"></div>
            </div>
          </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Modal -->
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
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

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

        function setLoading(value = true) {
            if (value) {
                $("#loading-modal").modal("show");
            } else {
                $("#loading-modal").modal("hide");
            }
        }
    </script>
    <script>
        var notificationsWrapper   = $('.dropdown-notifications');
        var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notificationsCount     = parseInt(notificationsCountElem.data('count'));
        var notifications          = notificationsWrapper.find('div.notifications-container');

        if (notificationsCount <= 0) {
          notificationsWrapper.hide();
        }
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher("40dfdfde5a90ba2ce71c", {
          encrypted: true,
          cluster: 'us2'
        });

        // Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('welcome');
        // Bind a function to a Event (the full Laravel class)
        channel.bind('App\\Events\\Welcome', function(data) {
          var existingNotifications = notifications.html();
          var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
          var newNotificationHtml = `
            <div class="card dropdown-toolbar-actions" style="padding: 10px;">
                <i class="fa fa-comment"></i>
                <a href="#">`+data.message+`</a>
            </div>
          `;

          notifications.html(newNotificationHtml + existingNotifications);
          notificationsCount += 1;
          notificationsCountElem.attr('data-count', notificationsCount);
          notificationsWrapper.find('.notify-count').text(notificationsCount);
          $("#notification-count").html(notificationsCount);
          notificationsWrapper.show();
        });
    </script>
</body>

</html>
