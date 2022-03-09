@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.statements') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.statements') }}</a></li>
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
                <a type="button" href="{{ route('statements') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.statements') }}</h3>
            <form role="form" action="{{ empty($statement) ? route('statements.store') : route('statements.update', $statement->id ?? '') }}" method="POST">
                @csrf
                @method(empty($statement) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('statement.subject') }}</label>
                    <input id="subject" type="text" name="subject" class="form-control" value="{{ $statement->subject ?? '' }}">
                    @if ($errors->get('subject'))
                    <p class="label-error">
                        @foreach ($errors->get('subject') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                <div class="form-group">
                    <label>{{ __('statement.header') }}</label>
                    <textarea rows="10" cols="50" name="statement" class="form-control" {{ (Auth::user()->can('update-statements')) ? '' : 'readonly disabled' }} >{{ empty($statement) ? '' : $statement->statement }}</textarea>
                    @if ($errors->get('statement'))
                    <p class="label-error">
                        @foreach ($errors->get('statement') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>

                @if (Auth::user()->can('update-statements'))
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
