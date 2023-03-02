@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('menu.statements') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upclass to Pro</a> -->
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
            @if (Auth::user()->can('create-statements'))
            <div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                <a type="button" href="{{ route('statements.new') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-plus"></i></a>
            </div>
            @endif
            <h3 class="box-title">{{ __('menu.statements') }}</h3>
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
                @if (count($statements) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ __('statement.header') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statements as $statement)
                            <tr>
                                <td>{{ $statement->id }}</td>
                                <td class="txt-oflo">{{ $statement->subject }}</td>
                                <td>
                                    <div class="d-flex">
                                        @if (Auth::user()->can(['read-statements']))
                                        <a type="button" href="{{ route('statements.show', $statement->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                        @endif
                                        @if (Auth::user()->can(['delete-statements']))
                                        <form class="btn" action="{{ route('statements.destroy', $statement->id) }}" method="post">
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
