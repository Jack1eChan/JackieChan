@extends('layouts.admin')

@section('title')
    工单列表
@endsection

@section('content-header')
    <h1>工单<small>查看系统上的所有工单。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">工单</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <form action="{{ route('admin.tickets.index') }}" method="POST">
            <div class="box @if($enabled == 'true') box-success @else box-danger @endif">
                <div class="box-header with-border">
                    <i class="fa fa-ticket"></i> <h3 class="box-title">工单系统 <small>设置是否开启工单系统。</small></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="control-label">工单系统开关</label>
                            <div>
                                <select name="enabled" class="form-control">
                                    <option @if ($enabled == 'false') selected @endif value="false">禁用</option>
                                    <option @if ($enabled == 'true') selected @endif value="true">启用</option>
                                </select>
                                <p class="text-muted"><small>设置用户是否可以通过成龙面板创建工单。</small></p>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                                <label class="control-label">最大工单数量</label>
                                <div>
                                    <input type="text" class="form-control" name="max" value="{{ $max }}" />
                                    <p class="text-muted"><small>设置每个用户可以创建的工单数量。</small></p>
                                </div>
                            </div>
                    </div>
                    {!! csrf_field() !!}
                    <button type="submit" name="_method" value="POST" class="btn btn-default pull-right">保存修改</button>
                </div>
            </div>
        </form>
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">工单列表</h3>
            </div>
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>工单 ID</th>
                            <th>用户邮箱</th>
                            <th>标题</th>
                            <th>创建于</th>
                            <th></th>
                        </tr>
                        @foreach ($tickets as $ticket)
                            <tr data-ticket="{{ $ticket->id }}">
                                <td><a href="{{ route('admin.tickets.view', $ticket->id) }}">{{ $ticket->id }}</a></td>
                                <td><a href="{{ route('admin.users.view', $ticket->client_id) }}">{{ $ticket->user->email ?? 'N/A' }}</a></td>
                                <td style="
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    max-width: 32ch;
                                "><code title="{{ $ticket->title }}">{{ $ticket->title }}</code></td>
                                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                <td class="text-center">
                                    @if($ticket->status == 'pending')
                                        <span class="label label-warning">待办</span>
                                    @elseif($ticket->status == 'in-progress')
                                        <span class="label label-primary">处理中</span>
                                    @elseif($ticket->status == 'unresolved')
                                        <span class="label label-danger">未解决</span>
                                    @else
                                        <span class="label label-success">已解决</span>
                                    @endif
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
