@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Dashboard</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a> -->
        <ol class="breadcrumb">
            <li><a href="#">Dashboard</a></li>
        </ol>
    </div>
</div>
<!-- /.row -->
<!-- ============================================================== -->
<!-- Different data widgets -->
<!-- ============================================================== -->
<!-- .row -->
@if (Auth::user()->can('read-dashboard'))
<div class="row">
    <div class="{{ Auth::user()->hasRole("responsible") ? "col-lg-6" : "col-lg-4" }} col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">{{ __('dashboard.total_students') }}</h3>
            <ul class="list-inline two-part">
                <!-- <li>
                    <div id="sparklinedash"></div>
                </li> -->
                <li>
                    <i class="fa fa-users" style="color: grey;"></i>
                </li>
                <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success">{{ $totalStudents }}</span></li>
            </ul>
        </div>
    </div>
    <div class="{{ Auth::user()->hasRole("responsible") ? "col-lg-6" : "col-lg-4" }} col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">{{ __('dashboard.new_students') }}</h3>
            <ul class="list-inline two-part">
                <!-- <li>
                    <div id="sparklinedash2"></div>
                </li> -->
                <li>
                    <i class="fa fa-users" style="color: yellow;"></i>
                </li>
                <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple">{{ $newStudents }}</span></li>
            </ul>
        </div>
    </div>
    @if (!Auth::user()->hasRole('responsible'))
    <div class="col-lg-4 col-sm-6 col-xs-12">
        <div class="white-box analytics-info">
            <h3 class="box-title">{{ __('dashboard.total_teachers') }}</h3>
            <ul class="list-inline two-part">
                <!-- <li>
                    <div id="sparklinedash3"></div>
                </li> -->
                <li>
                    <i class="fa fa-user" style="color: blue;"></i>
                </li>
                <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info">{{ $totalTeachers }}</span></li>
            </ul>
        </div>
    </div>
    @endif
</div>
@endif
<!--/.row -->
<!--row -->
<!-- /.row -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="white-box">
            <h3 class="box-title">{{ __('dashboard.monthly_grades') }}</h3>
            <ul class="list-inline text-right">
                <li>
                    <h5><i class="fa fa-circle m-r-5 text-info"></i>Mac</h5> </li>
                <li>
                    <h5><i class="fa fa-circle m-r-5 text-inverse"></i>Windows</h5> </li>
            </ul>
            <div id="ct-visits" style="height: 405px;"></div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- table -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <select class="form-control pull-right row b-none">
                    <option>March 2017</option>
                    <option>April 2017</option>
                    <option>May 2017</option>
                    <option>June 2017</option>
                    <option>July 2017</option>
                </select>
            </div>
            <h3 class="box-title">{{ __('dashboard.recent_grades') }}</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NAME</th>
                            <th>STATUS</th>
                            <th>DATE</th>
                            <th>PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td class="txt-oflo">Elite admin</td>
                            <td>SALE</td>
                            <td class="txt-oflo">April 18, 2017</td>
                            <td><span class="text-success">$24</span></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td class="txt-oflo">Real Homes WP Theme</td>
                            <td>EXTENDED</td>
                            <td class="txt-oflo">April 19, 2017</td>
                            <td><span class="text-info">$1250</span></td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td class="txt-oflo">Ample Admin</td>
                            <td>EXTENDED</td>
                            <td class="txt-oflo">April 19, 2017</td>
                            <td><span class="text-info">$1250</span></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td class="txt-oflo">Medical Pro WP Theme</td>
                            <td>TAX</td>
                            <td class="txt-oflo">April 20, 2017</td>
                            <td><span class="text-danger">-$24</span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td class="txt-oflo">Hosting press html</td>
                            <td>SALE</td>
                            <td class="txt-oflo">April 21, 2017</td>
                            <td><span class="text-success">$24</span></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td class="txt-oflo">Digital Agency PSD</td>
                            <td>SALE</td>
                            <td class="txt-oflo">April 23, 2017</td>
                            <td><span class="text-danger">-$14</span></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td class="txt-oflo">Helping Hands WP Theme</td>
                            <td>MEMBER</td>
                            <td class="txt-oflo">April 22, 2017</td>
                            <td><span class="text-success">$64</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================== -->
<!-- chat-listing & recent comments -->
<!-- ============================================================== -->
<div class="row">
    <!-- .col -->
    <div class="col-md-12 col-lg-8 col-sm-12">
        <div class="white-box">
            <h3 class="box-title">{{ __('dashboard.recent_warnings') }}</h3>
            <div class="comment-center p-t-10">
                <div class="comment-body">
                    <div class="user-img"> <img src="../plugins/images/users/pawandeep.jpg" alt="user" class="img-circle">
                    </div>
                    <div class="mail-contnet">
                        <h5>Pavan kumar</h5><span class="time">10:20 AM   20  may 2016</span>
                        <br/><span class="mail-desc">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo dui pellentesque molestie feugiat. Aenean commodo dui pellentesque molestie feugiat</span> <a href="javacript:void(0)" class="btn btn btn-rounded btn-default btn-outline m-r-5"><i class="ti-check text-success m-r-5"></i>Approve</a><a href="javacript:void(0)" class="btn-rounded btn btn-default btn-outline"><i class="ti-close text-danger m-r-5"></i> Reject</a>
                    </div>
                </div>
                <div class="comment-body">
                    <div class="user-img"> <img src="../plugins/images/users/sonu.jpg" alt="user" class="img-circle">
                    </div>
                    <div class="mail-contnet">
                        <h5>Sonu Nigam</h5><span class="time">10:20 AM   20  may 2016</span>
                        <br/><span class="mail-desc">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo dui pellentesque molestie feugiat. Aenean commodo dui pellentesque molestie feugiat</span>
                    </div>
                </div>
                <div class="comment-body b-none">
                    <div class="user-img"> <img src="../plugins/images/users/arijit.jpg" alt="user" class="img-circle">
                    </div>
                    <div class="mail-contnet">
                        <h5>Arijit singh</h5><span class="time">10:20 AM   20  may 2016</span>
                        <br/><span class="mail-desc">Donec ac condimentum massa. Etiam pellentesque pretium lacus. Phasellus ultricies dictum suscipit. Aenean commodo dui pellentesque molestie feugiat. Aenean commodo dui pellentesque molestie feugiat</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="panel">
            <div class="sk-chat-widgets">
                <div class="panel panel-default">
                    <div class="panel-heading">
                    {{ __('dashboard.last_user_warnings') }}
                    </div>
                    <div class="panel-body">
                        <ul class="chatonline">
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/genu.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                            </li>
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/ritesh.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                            </li>
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/arijit.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                            </li>
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/govinda.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/hritik.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                            </li>
                            <li>
                                <div class="call-chat">
                                    <button class="btn btn-success btn-circle btn-lg" type="button"><i class="fa fa-phone"></i></button>
                                    <button class="btn btn-info btn-circle btn-lg" type="button"><i class="fa fa-comments-o"></i></button>
                                </div>
                                <a href="javascript:void(0)"><img src="../plugins/images/users/varun.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.container-fluid -->
@endsection
