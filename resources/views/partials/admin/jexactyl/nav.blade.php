@section('jexactyl::nav')
    <div class="row">
        <div class="col-xs-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">

                    <li @if($activeTab === 'index') class="active "@endif>
                        <a href="{{ route('admin.index') }}">首页</a>
                    </li>
                    <li @if($activeTab === 'appearance') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.appearance') }}">外观</a>
                    </li>
                    <li @if($activeTab === 'mail') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.mail') }}">发信</a>
                    </li>
                    <li @if($activeTab === 'advanced') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.advanced') }}">高级</a>
                    </li>

                    <li style="margin-left: 5px; margin-right: 5px;"><a>-</a></li>

                    <li @if($activeTab === 'store') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.store') }}">商店</a>
                    </li>
                    <li @if($activeTab === 'registration') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.registration') }}">注册</a>
                    </li>
                    <li @if($activeTab === 'approvals') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.approvals') }}">审批</a>
                    </li>
                    <li @if($activeTab === 'server') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.server') }}">服务器设置</a>
                    </li>
                    <li @if($activeTab === 'referrals') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.referrals') }}">邀请</a>
                    </li>
                    <li @if($activeTab === 'alerts') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.alerts') }}">通知</a>
                    </li>
                    <li @if($activeTab === 'coupons') class="active" @endif>
                        <a href="{{ route('admin.jexactyl.coupons') }}">兑换码</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
