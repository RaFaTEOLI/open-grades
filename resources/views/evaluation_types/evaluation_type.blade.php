@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.evaluation_types') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.evaluation_types') }}</a></li>
        </ol>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('evaluation-types') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.evaluation_types') }}</h3>
            <form role="form" action="{{ empty($evaluationType) ? route('evaluation-types') : route('evaluation-types.update', $evaluationType->id ?? '') }}" method="POST">
                @csrf
                @method(empty($evaluationType) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('configuration.name') }}</label>
                    <input {{ Auth::user()->can(['update-evaluation-types']) ? '' : 'readonly' }} id="name" type="text" name="name" class="form-control" value="{{ $evaluationType->name ?? '' }}">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ __('evaluation.weight') }}</label>
                    <input {{ Auth::user()->can(['update-evaluation-types']) ? '' : 'readonly' }} id="weight" type="number" name="weight" class="form-control" value="{{ $evaluationType->weight ?? '' }}">
                    @if ($errors->get('weight'))
                    <p class="label-error">
                        @foreach ($errors->get('weight') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                @if (Auth::user()->can(['update-evaluation-types']))
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
