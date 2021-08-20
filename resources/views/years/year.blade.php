@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.years') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.years') }}</a></li>
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
                <a type="button" href="{{ route('years') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.years') }}</h3>
            <form role="form" action="{{ empty($year) ? route('years') : route('years.update', $year->id ?? '') }}" method="POST">
                @csrf
                @method(empty($year) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('school.start_date') }}</label>
                    <input id="start_date" type="date" name="start_date" class="form-control" value="{{ $year->start_date ?? '' }}">
                    @if ($errors->get('start_date'))
                    <p class="label-error">
                        @foreach ($errors->get('start_date') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <label>{{ __('school.end_date') }}</label>
                    <input id="end_date" type="date" name="end_date" class="form-control" value="{{ $year->end_date ?? '' }}">
                    @if ($errors->get('end_date'))
                    <p class="label-error">
                        @foreach ($errors->get('end_date') as $error)

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
