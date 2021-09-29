@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ Auth::user()->hasRole('responsible') || Auth::user()->hasRole('admin')  ? __('menu.classes') : __('menu.my_classes') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upclass to Pro</a> -->
        <ol class="breadcrumb">
            <li><a href="#">{{ Auth::user()->hasRole('responsible') || Auth::user()->hasRole('admin')  ? __('menu.classes') : __('menu.my_classes') }}</a></li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- table -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('classes') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-plus"></i></a>
            </div>
            <h3 class="box-title">{{ Auth::user()->hasRole('responsible') || Auth::user()->hasRole('admin')  ? __('menu.classes') : __('menu.my_classes') }}</h3>
            @if (is_array($errors))
            @foreach ($errors as $error)
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br />
            @endforeach
            @elseif (!empty($error))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br />
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('student_class.student') }}</th>
                            <th>{{ __('student_class.class') }}</th>
                            <th>{{ __('student_class.presence') }}</th>
                            <th>{{ __('student_class.absent') }}</th>
                            <th>{{ __('student_class.enroll_date') }}</th>
                            <th>{{ __('student_class.left_date') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td class="txt-oflo">{{ $class->user->name }}</td>
                            <td class="txt-oflo">{{ $class->class->id . ' - ' . $class->class->subject->name }}</td>
                            <td class="txt-oflo">{{ $class->presence }}</td>
                            <td class="txt-oflo">{{ $class->absent }}</td>
                            <td class="txt-oflo">{{ $class->enroll_date }}</td>
                            <td class="txt-oflo">{{ $class->left_date }}</td>
                            <td>
                                <div class="d-flex">
                                    @if (Auth::user()->hasRole('student'))
                                    <form class="btn" action="{{ route('student.classes.destroy', $class->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-times"></i> {{ __('student_class.quit') }}</button>
                                    </form>
                                    @endif
                                    @if (Auth::user()->hasRole('responsible') || Auth::user()->hasRole('admin'))
                                    <form class="btn" action="{{ route('responsible.student.classes.destroy', ["studentId" => $studentId, "classId" => $class->class->id]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-times"></i> {{ __('student_class.quit') }}</button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($classes) < 1) <div style="text-align: center;">{{ __('messages.no_records') }}
            </div>
            @endif
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
@endsection
