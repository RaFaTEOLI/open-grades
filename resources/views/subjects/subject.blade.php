@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('school.subjects') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">{{ __('school.subjects') }}</a></li>
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
                <a type="button" href="{{ route('subjects') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('school.subjects') }}</h3>
            <form role="form" action="{{ empty($subject) ? route('subjects') : route('subjects.update', $subject->id ?? '') }}" method="POST">
                @csrf
                @method(empty($subject) ? 'POST' : 'PUT')
                <div class="form-group">
                    <label>{{ __('school.name') }}</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ $subject->name ?? '' }}">
                    @if ($errors->get('name'))
                    <p class="label-error">
                        @foreach ($errors->get('name') as $error)

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
<script>
    function copyToClipboard() {
        const inputToCopy = document.querySelector('#link');
        inputToCopy.select();
        document.execCommand("copy");
        $.toast({
            heading: 'Open Grades',
            text: '<?= __("messages.copied") ?>',
            position: 'top-right',
            loaderBg: '#fff',
            icon: 'success',
            hideAfter: 5000,
            stack: 6
        });
    }
</script>
@endsection
