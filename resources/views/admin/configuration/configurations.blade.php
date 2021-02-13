@extends('layouts.app')

@section('content')
<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">{{ __('configuration.page_title') }}</h4>
    </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <!-- <a href="https://wrappixel.com/templates/ampleadmin/" target="_blank" class="btn btn-danger pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Upgrade to Pro</a> -->
        <ol class="breadcrumb">
            <li><a href="#">{{ __('configuration.page_title') }}</a></li>
        </ol>
    </div>
</div>
<!-- ============================================================== -->
<!-- table -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="white-box">
            <h3 class="box-title">{{ __('configuration.page_title') }}</h3>
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
                            <th>{{ __('configuration.name') }}</th>
                            <th>{{ __('configuration.value') }}</th>
                            <th>{{ __('timestamps.created_at') }}</th>
                            <th>{{ __('timestamps.updated_at') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($configurations as $configuration)
                        <form action="{{ route('configuration.update', $configuration->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <tr>
                                <td>{{ $configuration->id }}</td>
                                <td class="txt-oflo">{{ __("configuration.$configuration->name") }}</td>
                                <td><input name="value" class="form-control" value="{{ $configuration->value }}"></td>
                                <td><span class="text-success">{{ date("d/m/Y H:i:s", strtotime($configuration->created_at)) }}</span></td>
                                <td><span class="text-success">{{ date("d/m/Y H:i:s", strtotime($configuration->updated_at)) }}</span></td>
                                <td align="center">
                                    <div class="btn-group">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-save"></i></button>
                                    </div>
                                </td>
                            </tr>
                        </form>
                        @endforeach
                    </tbody>
                </table>
                @if (count($configurations) < 1) <div style="text-align: center;">{{ __('messages.no_records') }}
            </div>
            @endif
        </div>
    </div>
</div>
</div>
<!-- /.container-fluid -->
@endsection
