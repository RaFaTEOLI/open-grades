@extends('layouts.imports')

@section('content')
<?php

use App\Http\Controllers\API\HttpStatus;
?>
<section id="wrapper" class="error-page">
    <div class="error-box">
        <div class="error-body text-center">
            <h1 class="text-danger">{{ HttpStatus::UNAUTHORIZED }}</h1>
            <h3 class="text-uppercase">{{ __('informative.unauthorized') }}</h3>
            <a href="{{ route('home') }}" class="btn btn-danger btn-rounded waves-effect waves-light m-b-40">{{ __('informative.back_home') }}</a>
        </div>
        <footer class="footer text-center">2020 © Open Grades.</footer>
    </div>
</section>
@endsection