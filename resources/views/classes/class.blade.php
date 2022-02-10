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
                        @if (count($subjects) > 1)
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
                    <select {{ Auth::user()->hasRole('teacher') ? 'disabled' : '' }} name="user_id" class="form-control">
                        @if (count($teachers) > 1)
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

                @if (Auth::user()->can('update-classes'))
                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            @if (Auth::user()->can('create-students'))
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('students.new') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-plus"></i></a>
            </div>
            @endif
            <h3 class="box-title">{{ __('menu.students') }}</h3>
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
                            <th>{{ __('student.name') }}</th>
                            @if (Auth::user()->hasRole('admin'))
                            <th>{{ __('student.email') }}</th>
                            <th>{{ __('student.created_at') }}</th>
                            @endif
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $user)
                        @if ($user->id !== Auth::user()->id)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td class="txt-oflo">{{ $user->name }}</td>
                            @if (Auth::user()->hasRole('admin'))
                                <td>{{ $user->email }}</td>
                                <td><span class="text-success">{{ date("d/m/Y H:i:s", strtotime($user->created_at)) }}</span></td>
                            @endif
                            <td>
                                <div class="d-flex">
                                    @if (Auth::user()->can(['read-students']) && Auth::user()->hasRole(['admin', 'teacher']))
                                    <a type="button" href="{{ route('responsible.student.classes.show', ["studentId" => $user->id, "id" => $class->id]) }}" class="btn btn-warning"><i class="fa fa-eye"></i></a>
                                    @endif
                                    @if (Auth::user()->can(['update-students']))
                                    <a type="button" href="{{ route('students.show', $user->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if (Auth::user()->can(['delete-students']))
                                    <form style="padding: 0px;"  class="btn" action="{{ route('users.destroy', $user->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
                @if (count($students) < 1) <div style="text-align: center;">{{ __('messages.no_records') }}
            </div>
            @endif
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
