@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'appearance'])

@section('title')
    主题设置
@endsection

@section('content-header')
    <h1>成龙面板外观<small>配置成龙面板的主题。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.jexactyl.appearance') }}" method="POST">
            <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">常规设置 <small>配置常规外观设置。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">面板名称</label>
                                <div>
                                    <input type="text" class="form-control" name="app:name" value="{{ old('app:name', config('app.name')) }}" />
                                    <p class="text-muted"><small>这是在面板中使用的名称，以及发送给客户的电子邮件中使用的名称。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">面板Logo</label>
                                <div>
                                    <input type="text" class="form-control" name="app:logo" value="{{ $logo }}" />
                                    <p class="text-muted"><small>这是用于面板界面的Logo URL。</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">主题设置 <small>选择成龙面板的主题。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">面板主题</label>
                                <div>
                                    <select name="theme:admin" class="form-control">
                                        <option @if ($admin == 'jexactyl') selected @endif value="jexactyl">默认主题</option>
                                        <option @if ($admin == 'dark') selected @endif value="dark">暗黑主题</option>
                                        <option @if ($admin == 'light') selected @endif value="light">明亮主题</option>
                                        <option @if ($admin == 'blue') selected @endif value="blue">蓝色主题</option>
                                        <option @if ($admin == 'minecraft') selected @endif value="minecraft">我的世界主题</option>
                                    </select>
                                    <p class="text-muted"><small>设置成龙面板的界面主题。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">客户端背景</label>
                                <div>
                                    <input type="text" class="form-control" name="theme:user:background" value="{{ old('theme:user:background', config('theme.user.background')) }}" />
                                    <p class="text-muted"><small>如果在此处输入一个URL，客户页面将使用您的图像作为页面背景。</small></p>
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
