@extends('layouts.app')

@section('content')
<input type="hidden" id="hasSuccess" value="{{ session()->has('success') }}">
<input type="hidden" id="success" value="{{ session('success') }}">
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('invitation.invitations') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a> -->
        <ol class="breadcrumb">
            <li><a href="#">{{ __('invitation.invitations') }}</a></li>
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
                <a type="button" href="{{ route('invitations') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-arrow-left"></i></a>
            </div>
            <h3 class="box-title">{{ __('invitation.invitations') }}</h3>
            @csrf
            <form role="form" action="{{ route('invitations.store') }}" method="POST">
                @csrf
                @if (!empty($invitation))
                <div class="form-group">
                    <label>{{ __('invitation.link') }}</label>
                    <input id="link" class="form-control" value="{{ $invitation->link }}" readonly>
                </div>
                <div class="form-group">
                    <button type="button" onclick="copyToClipboard()" class="btn btn-success"><i class="fa fa-clipboard"></i> {{ __('actions.copy') }}</button>
                </div>
                @else
                <div class="form-group">
                    <label>{{ __('invitation.type') }}</label>
                    <select name="type" class="form-control">
                        <option value="STUDENT">{{ __('invitation.student') }}</option>
                        <option value="TEACHER">{{ __('invitation.teacher') }}</option>
                    </select>
                    @if ($errors->get('type'))
                    <p class="label-error">
                        @foreach ($errors->get('type') as $error)

                        <strong>{{ $error }}</strong>

                        @endforeach
                    </p>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ __('invitation.generate') }}</button>
                </div>
                @endif
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
