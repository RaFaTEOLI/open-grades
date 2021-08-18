@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.years') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a> -->
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
                <a type="button" href="{{ route('years.new') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-plus"></i></a>
            </div>
            <h3 class="box-title">{{ __('menu.years') }}</h3>
            @if (is_array($errors))
            @foreach ($errors as $error)
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br />
            @endforeach
            @elseif (!empty($error))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <br />
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('school.start_date') }}</th>
                            <th>{{ __('school.end_date') }}</th>
                            <th>{{ __('school.closed') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($years as $year)
                        <tr>
                            <td>{{ $year->id }}</td>
                            <td class="txt-oflo">{{ $year->start_date }}</td>
                            <td class="txt-oflo">{{ $year->end_date }}</td>
                            <td class="txt-oflo"><span class="badge badge-{{ $year->closed ? 'danger' : 'success' }}">{{ $year->closed ? __('informative.yes') : __('informative.no') }}</span></td>
                            <td>
                                <div class="d-flex">
                                    @if (Auth::user()->can(['update-years']))
                                    <form class="btn" action="{{ route('years.close', $year->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-secondary" {{ $year->closed ? 'disabled' : 'enabled' }} type="submit"><i class="fa fa-stop"></i></button>
                                    </form>
                                    <a type="button" href="{{ route('years.show', $year->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    @endif
                                    @if (Auth::user()->can(['delete-years']))
                                    <form class="btn" action="{{ route('years.destroy', $year->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($years) < 1) <div style="text-align: center;">{{ __('messages.no_records') }}
            </div>
            @endif
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
@endsection
