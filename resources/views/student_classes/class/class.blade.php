@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.classes') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
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
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('classes') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.classes') }}</h3>
            <form role="form" action="{{ empty($class) ? route('classes.store') : route('classes.update', $class->id ?? '') }}" method="POST">
                @csrf
                @method(empty($class) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('class.subject') }}</label>
                    <select name="subject_id" class="form-control">
                        @if (count($subjects) > 0)
                            @foreach ($subjects as $subject)
                                @if (!empty($class))
                                    <option {{ ($class->subject->id == $subject->id ? 'selected' : '') }} value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @else
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->get('subject_id'))
                    <p class="label-error">
                        @foreach ($errors->get('subject_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('class.grade') }}</label>
                    <select name="grade_id" class="form-control">
                        @if (count($grades) > 0)
                            @foreach ($grades as $grade)
                                @if (!empty($class))
                                    <option {{ ($class->grade->id == $grade->id ? 'selected' : '') }} value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @else
                                    <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->get('grade_id'))
                    <p class="label-error">
                        @foreach ($errors->get('grade_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('class.user') }}</label>
                    <select name="user_id" class="form-control">
                        @if (count($teachers) > 0)
                            @foreach ($teachers as $user)
                                @if (!empty($class))
                                    <option {{ ($class->user->id == $user->id ? 'selected' : '') }} value="{{ $user->id }}">{{ $user->name }}</option>
                                @else
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->get('user_id'))
                    <p class="label-error">
                        @foreach ($errors->get('user_id') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
