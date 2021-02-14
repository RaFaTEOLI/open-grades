@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('user.users') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('user.users') }}</a></li>
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
                <a type="button" href="{{ route('users') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('user.users') }}</h3>
            <form role="form" action="{{ empty($user) ? route('users') : route('users.update', $user->id ?? '') }}" method="POST">
                @csrf
                @method(empty($user) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('user.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ $user->name ?? '' }}">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ __('user.email') }}</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ $user->email ?? '' }}">
                    @if ($errors->get('email'))
                    <p class="label-error">
                        @foreach ($errors->get('email') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                @if (empty($user))
                <div class="form-group">
                    <label>{{ __('user.password') }}</label>
                    <input id="password" type="password" name="password" class="form-control" value="{{ $user->password ?? '' }}">
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
            @if (!empty($user))
            <hr />
                @if (count($roles) > 0)
                <div class="form-group">
                    <label>{{ __('user.types_to_add') }}</label>
                    <div class="form-group">
                    @foreach ($roles as $role)
                        <form class="btn" action="{{ route('users.role', ["userId" => $user->id, "roleId" => $role->id]) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success" type="submit">{{ __('role.' . strtolower($role->display_name)) }} <i class="fa fa-plus"></i></button>
                        </form>
                    @endforeach
                    </div>
                </div>
                @endif

                @if (count($user->roles) > 0)
                <div class="form-group">
                    <label>{{ __('user.types') }}</label>
                    <div class="form-group">
                    @foreach ($user->roles as $role)
                        <form class="btn" action="{{ route('users.role.remove', ["userId" => $user->id, "roleId" => $role->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-primary" type="submit">{{ __('role.' . strtolower($role->display_name)) }} <i class="fa fa-times"></i></button>
                        </form>
                    @endforeach
                    </div>
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
