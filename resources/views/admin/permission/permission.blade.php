@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('permission.permissions') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('permission.permissions') }}</a></li>
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
                <a type="button" href="{{ route('permissions') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('permission.permissions') }}</h3>
            @csrf
            <form permission="form" action="{{ empty($permission) ? route('permissions') : route('permissions.update', $permission->id ?? '') }}" method="POST">
                @csrf
                @method(empty($permission) ? 'POST' : 'PUT')

                @if (!empty($permission))
                <div class="form-group">
                    <label>{{ __('permission.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ $permission->name ?? '' }}">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ __('permission.display_name') }}</label>
                    <input id="display_name" type="text" name="display_name" class="form-control" value="{{ $permission->display_name ?? '' }}">
                    @if ($errors->get('display_name'))
                    <p class="label-error">
                        @foreach ($errors->get('display_name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('permission.description') }}</label>
                    <input id="description" type="text" name="description" class="form-control" value="{{ $permission->description ?? '' }}">
                    @if ($errors->get('description'))
                    <p class="label-error">
                        @foreach ($errors->get('description') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                @else
                <div class="form-group">
                    <label>{{ __('permission.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('permission.description') }}</label>
                    <input id="description" type="text" name="description" class="form-control">
                    @if ($errors->get('description'))
                    <p class="label-error">
                        @foreach ($errors->get('description') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="create" name="create">
                    <label class="form-check-label">
                        {{ __('permissions.create') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="read" name="read">
                    <label class="form-check-label">
                      {{ __('permissions.read') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="update" name="update">
                    <label class="form-check-label">
                        {{ __('permissions.update') }}
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="delete" name="delete">
                    <label class="form-check-label">
                        {{ __('permissions.delete') }}
                    </label>
                </div>
                @endif

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
