@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.warnings') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upclass to Pro</a> -->
        <ol class="breadcrumb">
            <li><a href="#">{{ __('menu.warnings') }}</a></li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- table -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            @if (Auth::user()->can('create-warnings'))
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('warnings.new') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-plus"></i></a>
            </div>
            @endif
            <h3 class="box-title">{{ __('menu.warnings') }}</h3>
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
                @if (count($warnings) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('class.class') }}</th>  
                                <th>{{ __('school.reporter') }}</th>
                                @if (!Auth::user()->hasRole('student'))
                                <th>{{ __('student.student') }}</th>
                                @endif
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warnings as $warning)
                            <tr>
                                <td>{{ $warning->id }}</td>
                                <td class="txt-oflo">{{'#' . $warning->class->id . ' - ' . $warning->class->grade->name . ' - ' . $warning->class->user->name }}</td>
                                @if (!Auth::user()->hasRole('student'))
                                <td class="txt-oflo">{{ $warning->student->name }}</td>
                                @endif
                                <td class="txt-oflo">{{ $warning->reporter->name }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if (Auth::user()->can(['read-warnings']))
                                        <a type="button" href="{{ route('warnings.show', $warning->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        @endif
                                        @if (Auth::user()->can(['delete-warnings']))
                                        <form class="btn" action="{{ route('warnings.destroy', $warning->id) }}" method="post">
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
                @else
                    <div style="text-align: center;">{{ __('messages.no_records') }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
