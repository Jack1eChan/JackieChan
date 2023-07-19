@extends('layouts.admin')
@include('partials/admin.jexactyl.nav', ['activeTab' => 'store'])

@section('title')
    商店设置
@endsection

@section('content-header')
    <h1>成龙面板商店<small>配置商店是否启用某些选项。</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">管理</a></li>
        <li class="active">成龙面板</li>
    </ol>
@endsection

@section('content')
    @yield('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <form action="{{ route('admin.jexactyl.store') }}" method="POST">
                <div class="box
                    @if($enabled == 'true')
                        box-success
                    @else
                        box-danger
                    @endif
                ">
                    <div class="box-header with-border">
                        <i class="fa fa-shopping-cart"></i> <h3 class="box-title">成龙面板商店 <small>配置商店是否启用某些选项。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">商店开关</label>
                                <div>
                                    <select name="store:enabled" class="form-control">
                                        <option @if ($enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以访问商店。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">PayPal 开关</label>
                                <div>
                                    <select name="store:paypal:enabled" class="form-control">
                                        <option @if ($paypal_enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($paypal_enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以通过PayPal购买积分。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Stripe 开关</label>
                                <div>
                                    <select name="store:stripe:enabled" class="form-control">
                                        <option @if ($stripe_enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($stripe_enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否可以通过Stripe购买积分。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="store:currency">货币名称</label>
                                <select name="store:currency" id="store:currency" class="form-control">
                                    @foreach ($currencies as $currency)
                                        <option @if ($selected_currency === $currency['code']) selected @endif value="{{ $currency['code'] }}">{{ $currency['name'] }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted"><small>成龙面板使用的货币名称。</small></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-money"></i> <h3 class="box-title">在线奖励 <small>配置在线奖励的规则。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">开关</label>
                                <div>
                                    <select name="earn:enabled" class="form-control">
                                        <option @if ($earn_enabled == 'false') selected @endif value="false">禁用</option>
                                        <option @if ($earn_enabled == 'true') selected @endif value="true">启用</option>
                                    </select>
                                    <p class="text-muted"><small>设置用户是否获得在线奖励。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每分钟获得的积分奖励</label>
                                <div>
                                    <input type="text" class="form-control" name="earn:amount" value="{{ $earn_amount }}" />
                                    <p class="text-muted"><small>用户每在线1分钟获得的积分数量。</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-dollar"></i> <h3 class="box-title">资源价格 <small>为资源定价。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">每 50% CPU 的价格</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:cpu" value="{{ $cpu }}" />
                                    <p class="text-muted"><small>用于计算 50% CPU 的总费用。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每 1GB 内存的价格</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:memory" value="{{ $memory }}" />
                                    <p class="text-muted"><small>U用于计算 1GB RAM 的总费用。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每 1GB 硬盘的价格</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:disk" value="{{ $disk }}" />
                                    <p class="text-muted"><small>用于计算 1GB 硬盘 的总费用。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每 1个服务器数量</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:slot" value="{{ $slot }}" />
                                    <p class="text-muted"><small>用于计算 1个 服务器数量 的总费用。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每 1个 网络端口</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:port" value="{{ $port }}" />
                                    <p class="text-muted"><small>用于计算 1个 网络端口 的总费用。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每 1个 服务器备份</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:backup" value="{{ $backup }}" />
                                    <p class="text-muted"><small>用于计算 1个 服务器备份 的总费用。</small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">每 1个 服务器数据库</label>
                                <div>
                                    <input type="text" class="form-control" name="store:cost:database" value="{{ $database }}" />
                                    <p class="text-muted"><small>用于计算 1个 服务器数据库 的总费用。</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-info">
                    <div class="box-header with-border">
                        <i class="fa fa-area-chart"></i> <h3 class="box-title">资源限制 <small>设置每个服务器的资源部署限制。</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label class="control-label">CPU 限制</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="store:limit:cpu" value="{{ $limit_cpu }}" />
                                        <span class="input-group-addon">%</span>
                                    </div>
                                    <p class="text-muted"><small>每个服务器可以部署的最大 CPU 百分比。 </small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">内存 限制</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="store:limit:memory" value="{{ $limit_memory }}" />
                                        <span class="input-group-addon">MB</span>
                                    </div>
                                    <p class="text-muted"><small>每个服务器可以部署的最大 内存 容量。 </small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">硬盘 限制</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="store:limit:disk" value="{{ $limit_disk }}" />
                                        <span class="input-group-addon">MB</span>
                                    </div>
                                    <p class="text-muted"><small>每个服务器可以部署的最大 硬盘 容量。 </small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">端口 限制</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="store:limit:port" value="{{ $limit_port }}" />
                                        <span class="input-group-addon">端口</span>
                                    </div>
                                    <p class="text-muted"><small>每个服务器可以部署的最大 端口 数量。 </small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">备份 限制</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="store:limit:backup" value="{{ $limit_backup }}" />
                                        <span class="input-group-addon">备份</span>
                                    </div>
                                    <p class="text-muted"><small>每个服务器可以部署的最大 备份 数量。 </small></p>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">数据库 限制</label>
                                <div>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="store:limit:database" value="{{ $limit_database }}" />
                                        <span class="input-group-addon">数据库</span>
                                    </div>
                                    <p class="text-muted"><small>每个服务器可以部署的最大 数据库 数量。 </small></p>
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
