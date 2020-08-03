@extends('layouts.basic')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('auth.verify_email') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('auth.fresh_verification') }}
                    </div>
                    @endif

                    {{ __('auth.before_proceeding') }}
                    {{ __('auth.did_not_receive_email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('auth.click_here_another_request') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection