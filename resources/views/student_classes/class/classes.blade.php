@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.classes') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upclass to Pro</a> -->
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.classes') }}</a></li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- table -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <h3 class="box-title">{{ __('menu.classes') }}</h3>
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
                            <th>{{ __('class.year') }}</th>
                            <th>{{ __('class.subject') }}</th>
                            <th>{{ __('class.grade') }}</th>
                            <th>{{ __('class.user') }}</th>
                            @if (Auth::user()->hasRole('student') && $canStudentEnroll->value)
                            <th>{{ __('messages.actions') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td class="txt-oflo">{{ $class->year->start_date }}</td>
                            <td class="txt-oflo">{{ $class->subject->name }}</td>
                            <td class="txt-oflo">{{ $class->grade->name }}</td>
                            <td class="txt-oflo">{{ $class->user->name }}</td>
                            @if (Auth::user()->hasRole('student') && $canStudentEnroll->value)
                            <td>
                                <div class="d-flex">
                                    <form class="btn" action="{{ route('student.classes.store') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="class_id" value="{{ $class->id }}" />
                                        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i> {{ __('student_class.enroll') }}</button>
                                    </form>
                                </div>
                            </td>
                            @endif
                            @if (Auth::user()->hasRole('responsible') || Auth::user()->hasRole('admin'))
                            <td>
                                <div class="d-flex">
                                    <form class="btn" id="enroll-student" action="{{ route('student.classes.store') }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="class_id" value="{{ $class->id }}" />
                                        <input type="hidden" class="student_id" name="student_id" value="0" />
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target=".bs-example-modal-sm"><i class="fa fa-check"></i> {{ __('student_class.enroll') }}</button>
                                    </form>
                                </div>
                            </td>
                            @endif
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
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myLargeModalLabel">{{ __('menu.students') }}</h4> </div>
            <div class="modal-body">
                <h4>{{ __('student_class.choose_student') }}</h4>
                <div class="form-group">
                    <select name="type" id="student_id" class="form-control">
                        @foreach ($students as $student)
                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="enroll()" class="btn btn-success waves-effect text-left" data-dismiss="modal"><i class="fa fa-check"></i> {{ __('student_class.enroll') }}</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<!-- /.container-fluid -->
<script>
    function enroll() {
        const enrollForm = document.querySelector('#enroll-student');
        const chosenStudentId = document.querySelector('#student_id').value;
        document.querySelectorAll('.student_id').forEach(studentOption => {
            studentOption.value = chosenStudentId;
        });
        enrollForm.submit();
    }
</script>
@endsection
