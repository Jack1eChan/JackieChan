@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'referrals'])

@section('title')
    邀请系统
@endsection

@section('content-header')
    <h1>邀请 系统<small>允许用户邀请他人使用面板以赚取积分。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
        <form action="{{ route('admin.jexactyl.referrals') }}" method="POST">
                <div class="box
                    @if($enabled == 'true')
                        box-success
                    @else
                        box-danger
                    @endif
                ">
                    <div class="box-header with-border">
                        <i class="fa fa-user-plus"></i> <h3 class="box-title">邀请设置 <small>允许用户邀请其他人使用本面板。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">邀请 系统</label>
                                <div>
                                    <select name="enabled" class="form-control">
                                        <option @if ($enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以进行邀请。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每邀请 1人 的奖励</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" id="reward" name="reward" class="form-control" value="{{ $reward }}" />
                                        <span class="input-group-addon">积分</span>
                                    </div>
                                    <p class="text-muted"><small>当用户邀请他人或有人使用邀请代码时，给予用户的积分数量。</small></p>
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
