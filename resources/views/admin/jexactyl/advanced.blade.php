@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'advanced'])

@section('title')
    高级设置
@endsection

@section('content-header')
    <h1>高级设置<small>配置成龙面板的高级设置。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
        <form action="{{ route('admin.jexactyl.advanced') }}" method="POST">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">安全设置</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">要求使用双因素身份验证</label>
                                    <div>
                                        <div class="btn-group" data-toggle="buttons">
                                            @php
                                                $level = old('Jexactyl:auth:2fa_required', config('jexactyl.auth.2fa_required'));
                                            @endphp
                                            <label class="btn btn-primary @if ($level == 0) active @endif">
                                                <input type="radio" name="Jexactyl:auth:2fa_required" autocomplete="off" value="0" @if ($level == 0) checked @endif> 不需要
                                            </label>
                                            <label class="btn btn-primary @if ($level == 1) active @endif">
                                                <input type="radio" name="Jexactyl:auth:2fa_required" autocomplete="off" value="1" @if ($level == 1) checked @endif> 仅管理员需要
                                            </label>
                                            <label class="btn btn-primary @if ($level == 2) active @endif">
                                                <input type="radio" name="Jexactyl:auth:2fa_required" autocomplete="off" value="2" @if ($level == 2) checked @endif> 所有用户需要
                                            </label>
                                        </div>
                                        <p class="text-muted"><small>如果启用，任何属于所选分组的帐户将需要启用双因素身份验证才能使用面板。</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box" hidden>
                        <div class="box-header with-border">
                            <h3 class="box-title">reCAPTCHA</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">状态</label>
                                    <div>
                                        <select class="form-control" name="recaptcha:enabled">
                                            <option value="true">启用</option>
                                            <option value="false" @if(old('recaptcha:enabled', config('recaptcha.enabled')) == '0') selected @endif>禁用</option>
                                        </select>
                                        <p class="text-muted small">If enabled, login forms and password reset forms will do a silent captcha check and display a visible captcha if needed.</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Site Key</label>
                                    <div>
                                        <input type="text" required class="form-control" name="recaptcha:website_key" value="{{ old('recaptcha:website_key', config('recaptcha.website_key')) }}">
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Secret Key</label>
                                    <div>
                                        <input type="text" required class="form-control" name="recaptcha:secret_key" value="{{ old('recaptcha:secret_key', config('recaptcha.secret_key')) }}">
                                        <p class="text-muted small">Used for communication between your site and Google. Be sure to keep it a secret.</p>
                                    </div>
                                </div>
                            </div>
                            @if($warning)
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="alert alert-warning no-margin">
                                            You are currently using reCAPTCHA keys that were shipped with this Panel. For improved security it is recommended to <a href="https://www.google.com/recaptcha/admin">generate new invisible reCAPTCHA keys</a> that tied specifically to your website.
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">HTTP 连接</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">连接超时</label>
                                    <div>
                                        <input type="number" required class="form-control" name="Jexactyl:guzzle:connect_timeout" value="{{ old('Jexactyl:guzzle:connect_timeout', config('jexactyl.guzzle.connect_timeout')) }}">
                                        <p class="text-muted small">在抛出错误之前等待打开连接的时间（以秒为单位）。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label">请求超时</label>
                                    <div>
                                        <input type="number" required class="form-control" name="Jexactyl:guzzle:timeout" value="{{ old('Jexactyl:guzzle:timeout', config('jexactyl.guzzle.timeout')) }}">
                                        <p class="text-muted small">在抛出错误之前等待请求完成的时间（以秒为单位）。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">自动创建端口</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">状态</label>
                                    <div>
                                        <select class="form-control" name="Jexactyl:client_features:allocations:enabled">
                                            <option value="false">禁用</option>
                                            <option value="true" @if(old('Jexactyl:client_features:allocations:enabled', config('jexactyl.client_features.allocations.enabled'))) selected @endif>启用</option>
                                        </select>
                                        <p class="text-muted small">如果启用，用户将可以通过前端界面给他们的服务器自动创建新的端口。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">起始端口</label>
                                    <div>
                                        <input type="number" class="form-control" name="Jexactyl:client_features:allocations:range_start" value="{{ old('Jexactyl:client_features:allocations:range_start', config('jexactyl.client_features.allocations.range_start')) }}">
                                        <p class="text-muted small">可以自动分配的端口范围的起始端口。</p>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">结束端口</label>
                                    <div>
                                        <input type="number" class="form-control" name="Jexactyl:client_features:allocations:range_end" value="{{ old('Jexactyl:client_features:allocations:range_end', config('jexactyl.client_features.allocations.range_end')) }}">
                                        <p class="text-muted small">可以自动分配的端口范围的结束端口。</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">保存设置</button>
                </div>
            </div>
        </form>
@endsection
