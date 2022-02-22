@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.grades') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.grades') }}</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('grades') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.grades') }}</h3>
            <form role="form" action="{{ empty($grade) ? route('grades') : route('grades.update', $grade->id ?? '') }}" method="POST">
                @csrf
                @method(empty($grade) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('configuration.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ $grade->name ?? '' }}"  {{ (Auth::user()->can('create-grades') || Auth::user()->can('update-grades')) ? '' : 'disabled' }}>
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                @if (Auth::user()->can('create-grades') || Auth::user()->can('update-grades'))
                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
                @endif
            </form>
        </div>
    </div>
</div>

@if (!empty($grade))
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('classes') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.classes') }}</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('class.year') }}</th>
                            <th>{{ __('class.subject') }}</th>
                            <th>{{ __('class.user') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grade->classes as $class)
                        <tr>
                            <td>{{ $class->id }}</td>
                            <td class="txt-oflo">{{ $class->year->start_date }}</td>
                            <td class="txt-oflo">{{ $class->subject->name }}</td>
                            <td class="txt-oflo">{{ $class->user->name }}</td>
                            <td>
                                <div class="d-flex">
                                    @if (Auth::user()->can(['update-classes']))
                                    <a type="button" href="{{ route('classes.show', $class->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if (Auth::user()->can(['delete-classes']))
                                    <form class="btn" action="{{ route('classes.destroy', $class->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($grade->classes) < 1) <div style="text-align: center;">{{ __('messages.no_records') }}
            </div>
            @endif
        </div>
    </div>
</div>
@endif
<!-- /.container-fluid -->
@endsection
