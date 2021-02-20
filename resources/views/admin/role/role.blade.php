@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('role.roles') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('role.roles') }}</a></li>
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
                <a type="button" href="{{ route('roles') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('role.roles') }}</h3>
            @csrf
            <form role="form" action="{{ empty($role) ? route('roles') : route('roles.update', $role->id ?? '') }}" method="POST">
                @csrf
                @method(empty($role) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('role.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ $role->name ?? '' }}">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ __('role.display_name') }}</label>
                    <input id="display_name" type="text" name="display_name" class="form-control" value="{{ $role->display_name ?? '' }}">
                    @if ($errors->get('display_name'))
                    <p class="label-error">
                        @foreach ($errors->get('display_name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('role.description') }}</label>
                    <input id="description" type="text" name="description" class="form-control" value="{{ $role->description ?? '' }}">
                    @if ($errors->get('description'))
                    <p class="label-error">
                        @foreach ($errors->get('description') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-success">{{ __('actions.save') }}</button>
                </div>
            </form>
            @if (!empty($role))
            <hr />
                @if (count($permissions) > 0)
                <div class="form-group">
                    <label>{{ __('user.types_to_add') }}</label>
                    <div class="form-group">
                    @foreach ($permissions as $permission)
                    <?php
                    $permissionSteps = explode(" ", $permission->display_name);
                    $action = strtolower($permissionSteps[0]);
                    $model = strtolower($permissionSteps[1]);
                    ?>
                        <form class="btn" action="{{ route('roles.permission.update', ["roleId" => $role->id, "permissionId" => $permission->id]) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success" type="submit">{{ __("permissions.{$action}") . ' ' . __("permissions.{$model}") }} <i class="fa fa-plus"></i></button>
                        </form>
                    @endforeach
                    </div>
                </div>
                @endif

                @if (count($role->permissions) > 0)
                <div class="form-group">
                    <label>{{ __('user.types') }}</label>
                    <div class="form-group">
                    @foreach ($role->permissions as $permission)
                    <?php
                    $permissionSteps = explode(" ", $permission->display_name);
                    $action = strtolower($permissionSteps[0]);
                    $model = strtolower($permissionSteps[1]);
                    ?>
                        <form class="btn" action="{{ route('roles.permission.remove', ["roleId" => $role->id, "permissionId" => $permission->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary" type="submit">{{ __("permissions.{$action}") . ' ' . __("permissions.{$model}") }} <i class="fa fa-times"></i></button>
                        </form>
                    @endforeach
                    </div>
                </div>

                @if ($errors->get('role_id'))
                <p class="label-error">
                    @foreach ($errors->get('role_id') as $error)

                    <strong>{{ $error }}</strong>

                    @endforeach
                </p>
                @endif

                @if ($errors->get('permission_id'))
                <p class="label-error">
                    @foreach ($errors->get('permission_id') as $error)

                    <strong>{{ $error }}</strong>

                    @endforeach
                </p>
                @endif

                @endif
            @endif
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
