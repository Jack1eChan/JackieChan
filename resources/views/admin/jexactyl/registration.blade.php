@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'registration'])

@section('title')
    注册设置
@endsection

@section('content-header')
    <h1>用户注册<small>配置成龙面板的用户注册设置。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
@yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.jexactyl.registration') }}" method="POST">
                <div class="box
                @if($enabled == 'true') box-success @else box-danger @endif">
                    <div class="box-header with-border">
                        <i class="fa fa-at"></i> <h3 class="box-title">通过邮箱注册 <small>邮箱注册和登录的设置。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">开关</label>
                                <div>
                                    <select name="registration:enabled" class="form-control">
                                        <option @if ($enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以使用邮箱注册账户。</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box @if($discord_enabled == 'true') box-success @else box-danger @endif" hidden>
                    <div class="box-header with-border">
                        <i class="fa fa-comments-o"></i> <h3 class="box-title">Registration via Discord <small>The settings for Discord registration and logins.</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">开关</label>
                                <div>
                                    <select name="discord:enabled" class="form-control">
                                        <option @if ($discord_enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($discord_enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    @if($discord_enabled != 'true')
                                        <p class="text-danger">如果禁用此功能，用户将无法使用 Discord 进行注册或登录!</p>
                                    @else
                                        <p class="text-muted"><small>设置用户是否可以使用Discord注册账户。</small></p>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Discord Client ID</label>
                                <div>
                                    <input type="text" class="form-control" name="discord:id" value="{{ $discord_id }}" />
                                    <p class="text-muted"><small>The client ID for your OAuth application. Typically 17-20 digits long.</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Discord Client Secret</label>
                                <div>
                                    <input type="password" class="form-control" name="discord:secret" value="{{ $discord_secret }}" />
                                    <p class="text-muted"><small>The client secret for your OAuth application. Treat this like a password.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-envelope"></i> 邮箱验证 <small>设置用户是否需要邮箱验证。</small></h3>
                    </div>
                    <div class="box-body row">
                        <div class="form-group col-md-4">
                            <label for="verification" class="control-label">状态</label>
                            <select name="registration:verification" id="verification" class="form-control">
                                <option value="{{ true }}" @if ($verification) selected @endif>启用</option>
                                <option value="{{ false }}" @if (!$verification) selected @endif>禁用</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-microchip"></i> <h3 class="box-title">默认资源 <small>注册时分配给用户的默认资源。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">CPU 百分比</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:cpu" value="{{ $cpu }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 CPU 百分比。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">内存 容量</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:memory" value="{{ $memory }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 内存 容量(MB)。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">硬盘 容量</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:disk" value="{{ $disk }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 硬盘 容量(MB)。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">服务器 数量</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:slot" value="{{ $slot }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 服务器 数量。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">端口 数量</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:port" value="{{ $port }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 端口 数量。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">备份 数量</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:backup" value="{{ $backup }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 备份 数量。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">数据库 数量</label>
                                <div>
                                    <input type="text" class="form-control" name="registration:database" value="{{ $database }}" />
                                    <p class="text-muted"><small>注册时分配给用户的 数据库 数量。</small></p>
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
