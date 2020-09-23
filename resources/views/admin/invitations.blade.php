@extends('layouts.app')

@section('content')
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
                <a type="button" href="{{ route('invitations.new') }}" class="btn btn-success pull-right row b-none"><i class="fa fa-plus"></i></a>
            </div>
            <h3 class="box-title">{{ __('invitation.invitations') }}</h3>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('invitation.user') }}</th>
                            <th>{{ __('invitation.link') }}</th>
                            <th>{{ __('invitation.type') }}</th>
                            <th>{{ __('invitation.created_at') }}</th>
                            <th>{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invitations as $invitation)
                        <tr>
                            <td>{{ $invitation->id }}</td>
                            <td class="txt-oflo">{{ $invitation->user->name }}</td>
                            <td>{{ $invitation->hash }}</td>
                            <td class="txt-oflo">{{ $invitation->type }}</td>
                            <td><span class="text-success">{{ date("d/m/Y H:i:s", strtotime($invitation->created_at)) }}</span></td>
                            <td align="center">
                                <div class="btn-group">
                                    <a type="button" href="{{ route('invitations.show', ['id' => $invitation->id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@endsection
