@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'approvals'])

@section('title')
    审批设置
@endsection

@section('content-header')
    <h1>用户审批<small>允许或拒绝创建账户的请求。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <form action="{{ route('admin.jexactyl.approvals') }}" method="POST">
        <div class="row">
            <div class="col-xs-12">
                <div class="box
                    @if($enabled == 'true')
                        box-success
                    @else
                        box-danger
                    @endif
                ">
                    <div class="box-header with-border">
                        <i class="fa fa-users"></i>
                        <h3 class="box-title">审批系统 <small>设置是否启用或禁用审批系统。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">开关</label>
                                <div>
                                    <select name="enabled" class="form-control">
                                        <option @if ($enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否需要管理员批准才能使用面板。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4" hidden>
                                <label class="control-label" for="webhook">Webhook URL</label>
                                <input name="webhook" id="webhook" class="form-control" value="{{ $webhook }}">
                                <p class="text-muted"><small>Provide the Discord Webhook URL to use when a user needs to be approved.</small></p>
                            </div>
                        </div>
                    </div>
                    <div class="box box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">保存修改</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <i class="fa fa-list"></i>
                    <h3 class="box-title">审批请求 <small>允许或拒绝创建账户的请求。</small></h3>
                    <form id="massdenyform" action="{{ route('admin.jexactyl.approvals.all', 'deny') }}" method="POST">
                        {!! csrf_field() !!}
                        <button id="denyAllBtn" class="btn btn-danger pull-right">拒绝全部</button>
                    </form>
                    <form id="massapproveform" action="{{ route('admin.jexactyl.approvals.all', 'approve') }}" method="POST">
                        {!! csrf_field() !!}
                        <button id="approveAllBtn" class="btn btn-success pull-right">允许全部</button>
                    </form>
                 </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <th>用户 ID</th>
                                <th>邮箱</th>
                                <th>用户名</th>
                                <th>注册时间</th>
                                <th></th>
                                <th></th>
                            </tr>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <code>{{ $user->id }}</code>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        <code>{{ $user->username }}</code> ({{ $user->name_first }} {{ $user->name_last }})
                                    </td>
                                    <td>
                                        {{ $user->created_at->diffForHumans() }}
                                    </td>
                                    <td class="text-center">
                                        <form id="approveform" action="{{ route('admin.jexactyl.approvals.approve', $user->id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            <button id="approvalApproveBtn" class="btn btn-xs btn-default">
                                                <i class="fa fa-check text-success"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-center">
                                        <form id="denyform" action="{{ route('admin.jexactyl.approvals.deny', $user->id) }}" method="POST">
                                            {!! csrf_field() !!}
                                            <button id="approvalDenyBtn" class="btn btn-xs btn-default">
                                                <i class="fa fa-times text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#approvalDenyBtn').on('click', function (event) {
        event.preventDefault();

        swal({
            type: 'error',
            title: 'Deny this request?',
            text: 'This will remove this user from the Panel immediately.',
            showCancelButton: true,
            confirmButtonText: 'Deny',
            confirmButtonColor: 'red',
            closeOnConfirm: false
        }, function () {
            $('#denyform').submit()
        });
    });

    $('#approvalApproveBtn').on('click', function (event) {
        event.preventDefault();

        swal({
            type: 'success',
            title: 'Approve this request?',
            text: 'This user will gain access to the Panel immediately.',
            showCancelButton: true,
            confirmButtonText: 'Approve',
            confirmButtonColor: 'green',
            closeOnConfirm: false
        }, function () {
            $('#approveform').submit()
        });
    });

    $('#approveAllBtn').click(function (event) {
        event.preventDefault();
        swal({
            title: 'Approve All Users?',
            text: 'This will approve all of the users waiting for approval.',
            showCancelButton: true,
            confirmButtonText: 'Approve All',
            confirmButtonColor: 'green',
            closeOnConfirm: false
        }, function () {
            $('#massapproveform').submit()
        });
    });

    $('#denyAllBtn').click(function (event) {
        event.preventDefault();
        swal({
            title: 'Deny All Users?',
            text: 'This will deny all of the users waiting for approval.',
            showCancelButton: true,
            confirmButtonText: 'Deny All',
            confirmButtonColor: 'red',
            closeOnConfirm: false
        }, function () {
            $('#massdenyform').submit()
        });
    });
    </script>
@endsection
