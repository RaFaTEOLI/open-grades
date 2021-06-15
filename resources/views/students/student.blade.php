@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('student.students') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('student.students') }}</a></li>
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
                @if (Auth::user()->hasRole('student'))
                @else
                    <a type="button" href="{{ route('students') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
                @endif
            </div>
            <h3 class="box-title">{{ __('student.students') }}</h3>
            <form role="form" action="{{ empty($student) ? route('students') : route('students.update', $student->id ?? '') }}" method="POST">
                @csrf
                @method(empty($student) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('student.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ $student->name ?? '' }}">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ __('student.email') }}</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ $student->email ?? '' }}">
                    @if ($errors->get('email'))
                    <p class="label-error">
                        @foreach ($errors->get('email') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                @if (empty($student))
                <div class="form-group">
                    <label>{{ __('student.password') }}</label>
                    <input id="password" type="password" name="password" class="form-control" value="{{ $student->password ?? '' }}">
                    @if ($errors->get('password'))
                    <p class="label-error">
                        @foreach ($errors->get('password') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
            </form>
            @if (!empty($student))
            <hr />
                @if (count($student->responsibles) > 0)
                    <div class="form-group">
                        <label>{{ __('student.responsibles') }}</label>
                        <div class="form-group">
                        @foreach ($student->responsibles as $responsible)
                            @if (Auth::user()->can(['update-students']))
                                <form action="{{ route('students.responsible.remove', ["studentId" => $student->id, "responsibleId" => $responsible->id]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-primary" type="submit" onclick="setLoading()">{{ $responsible->name . ' - ' . $responsible->email }} <i class="fa fa-times"></i></button>
                                </form>
                            @else
                                <div class="form-group">
                                    <button class="btn btn-success" type="button" onclick="setLoading()">{{ $responsible->name . ' - ' . $responsible->email }} </button>
                                </div>
                            @endif
                        @endforeach
                        </div>
                    </div>

                    @if ($errors->get('student_id'))
                    <p class="label-error">
                        @foreach ($errors->get('student_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif

                    @if ($errors->get('responsible_id'))
                    <p class="label-error">
                        @foreach ($errors->get('responsible_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                    <hr />
                @endif

                @if (empty($invitation))
                    @if ($errors->get('student_id'))
                    <p class="label-error">
                        @foreach ($errors->get('student_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif

                    <form action="{{ route('students.responsible.link') }}" method="post">
                        @csrf
                        @method('POST')
                        <input hidden name="student_id" value="{{ $student->id }}" />
                        <button class="btn btn-secondary" type="submit" onclick="setLoading()">{{ __('student.new_responsible') }} <i class="fa fa-link"></i></button>
                    </form>
                @else
                    <div class="form-group">
                        <label>{{ __('invitation.link') }}</label>
                        <input id="link" class="form-control" value="{{ $invitation->link }}" readonly>
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="copyToClipboard()" class="btn btn-success"><i class="fa fa-clipboard"></i> {{ __('actions.copy') }}</button>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>
<!-- /.container-fluid -->
<script>
    function copyToClipboard() {
        const inputToCopy = document.querySelector('#link');
        inputToCopy.select();
        document.execCommand("copy");
        $.toast({
            heading: 'Open Grades',
            text: '<?= __("messages.copied") ?>',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 5000,
            stack: 6
        });
    }
</script>
@endsection
