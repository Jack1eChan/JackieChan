@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'coupons'])

@section('title')
    兑换码设置
@endsection

@section('content-header')
    <h1>兑换码<small>创建并管理兑换码。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <form action="{{ route('admin.jexactyl.coupons') }}" method="POST">
        <div class="row">
            <div class="col-xs-12">
                <div class="box @if($enabled) box-success @else box-danger @endif">
                    <div class="box-header with-border">
                        <i class="fa fa-cash"></i>
                        <h3 class="box-title">兑换码系统</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="enabled" class="control-label">状态</label>
                                <select name="enabled" id="enabled" class="form-control">
                                    <option value="1" @if($enabled) selected @endif>启用</option>
                                    <option value="0" @if(!$enabled) selected @endif>禁用</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="PATCH" class="btn btn-default pull-right">保存</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <form action="{{ route('admin.jexactyl.coupons.store') }}" method="POST">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">创建兑换码</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="code">兑换码</label>
                                <input type="text" name="code" id="code" class="form-control"/>
                                <small>唯一的兑换码。</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="credits">积分</label>
                                <input type="number" name="credits" id="credits" class="form-control"/>
                                <small>使用兑换码时获得的积分。</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="expires">到期时间</label>
                                <input type="number" name="expires" id="expires" class="form-control" value="12"/>
                                <small>优惠券过期前的时间（以小时为单位）。留空表示永不过期。</small>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="uses">最大使用次数</label>
                                <input type="number" name="uses" id="uses" class="form-control" value="1"/>
                                <small>此兑换码的最大使用次数。</small>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {!! csrf_field() !!}
                        <button type="submit" name="_method" value="POST" class="btn btn-default pull-right">创建</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">兑换码</h3>
                </div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>ID</th>
                            <th>兑换码</th>
                            <th>积分</th>
                            <th>剩余使用次数</th>
                            <th>到期时间</th>
                            <th>状态</th>
                        </tr>
                        @foreach($coupons as $coupon)
                            <tr>
                                <td>{{ $coupon->id }}</td>
                                <td>{{ $coupon->code }}</td>
                                <td>{{ $coupon->cr_amount }}</td>
                                <td>{{ $coupon->uses }}</td>
                                <td>{{ $coupon->expires }}</td>
                                <td>@if($coupon->expired) 已到期 @else 可使用 @endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
