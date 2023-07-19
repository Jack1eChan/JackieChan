@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'server'])

@section('title')
    服务器设置
@endsection

@section('content-header')
    <h1>服务器设置<small>配置成龙面板的服务器设置。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.jexactyl.server') }}" method="POST">
                <div class="box
                    @if($enabled == 'true')
                        box-success
                    @else
                        box-danger
                    @endif
                ">
                    <div class="box-header with-border">
                        <i class="fa fa-clock-o"></i> <h3 class="box-title">服务器 续订 <small>配置服务器续订的设置。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">续订系统</label>
                                <div>
                                    <select name="enabled" class="form-control">
                                        <option @if ($enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否必须续订他们的服务器。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">默认续订计时器</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" id="default" name="default" class="form-control" value="{{ $default }}" />
                                        <span class="input-group-addon">天</span>
                                    </div>
                                    <p class="text-muted"><small>确定服务器在首次续订到期之前的天数。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">续订 金额</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" id="cost" name="cost" class="form-control" value="{{ $cost }}" />
                                        <span class="input-group-addon">积分</span>
                                    </div>
                                    <p class="text-muted"><small>设置续订所需的积分数量。</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box
                    @if($editing == 'true')
                        box-success
                    @else
                        box-danger
                    @endif
                ">
                    <div class="box-header with-border">
                        <i class="fa fa-server"></i> <h3 class="box-title">服务器设置 <small>配置服务器设置。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">修改服务器资源</label>
                                <div>
                                    <select name="editing" class="form-control">
                                        <option @if ($editing == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($editing == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以修改分配给他们的服务器的资源数量。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">允许删除服务器</label>
                                <div>
                                    <select name="deletion" class="form-control">
                                        <option @if ($deletion == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($deletion == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以删除自己的服务器。（默认:开启）</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {!! csrf_field() !!}
                <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">保存修改</button>
            </form>
        </div>
    </div>
@endsection
