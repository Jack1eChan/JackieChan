@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'alerts'])

@section('title')
    通知设置
@endsection

@section('content-header')
    <h1>成龙面板通知<small>通过界面给用户发送通知。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.jexactyl.alerts') }}" method="POST">
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">通知 设置 <small>配置当前通知设置。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">通知 类型</label>
                                <div>
                                <select name="alert:type" class="form-control">
                                        <option @if ($type == 'success') selected @endif value="success">成功</option>
                                        <option @if ($type == 'info') selected @endif value="info">信息</option>
                                        <option @if ($type == 'warning') selected @endif value="warning">警告</option>
                                        <option @if ($type == 'danger') selected @endif value="danger">严重</option>
                                    </select>
                                    <p class="text-muted"><small>这是发送到界面的通知类型。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">通知 信息</label>
                                <div>
                                    <input type="text" class="form-control" name="alert:message" value="{{ $message }}" />
                                    <p class="text-muted"><small>这是通知中包含的文本内容。</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! csrf_field() !!}
                <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">修改通知</button>
            </form>
            <form action="{{ route('admin.jexactyl.alerts.remove') }}" method="POST">
                {!! csrf_field() !!}
                <button type="submit" name="_method" value="POST" class="btn btn-danger pull-right" style="margin-right: 8px;">删除通知</button>
            </form>
        </div>
    </div>
@endsection
