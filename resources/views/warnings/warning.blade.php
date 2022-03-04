@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.warnings') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.warnings') }}</a></li>
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
                <a type="button" href="{{ route('warnings') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.warnings') }}</h3>
            <form role="form" action="{{ empty($warning) ? route('warnings.store') : route('warnings.update', $warning->id ?? '') }}" method="POST">
                @csrf
                @method(empty($warning) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('student.student') }}</label>
                    <select name="student_id" class="form-control">
                        @if (count($students) > 0)
                            @foreach ($students as $student)
                                @if (!empty($warning))
                                    <option {{ ($warning->student->id == $student->id ? 'selected' : '') }} value="{{ $student->id }}">{{ $student->name }}</option>
                                @else
                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->get('student_id'))
                    <p class="label-error">
                        @foreach ($errors->get('student_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('class.class') }}</label>
                    <select name="class_id" class="form-control">
                        @if (count($classes) > 0)
                            @foreach ($classes as $class)
                                @if (!empty($class))
                                    <option {{ ($warning->class->id == $class->id ? 'selected' : '') }} value="{{ $class->id }}">{{ $class->name }}</option>
                                @else
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->get('class_id'))
                    <p class="label-error">
                        @foreach ($errors->get('class_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('class.user') }}</label>
                    <input name="description" class="form-control" />
                    @if ($errors->get('description'))
                    <p class="label-error">
                        @foreach ($errors->get('description') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                @if (Auth::user()->can('update-warnings'))
                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
