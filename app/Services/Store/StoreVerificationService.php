<?php

namespace Jexactyl\Services\Store;

use Jexactyl\Models\Node;
use Illuminate\Support\Facades\DB;
use Jexactyl\Exceptions\DisplayException;
use Jexactyl\Contracts\Repository\SettingsRepositoryInterface;
use Jexactyl\Http\Requests\Api\Client\Store\CreateServerRequest;

class StoreVerificationService
{
    public function __construct(private SettingsRepositoryInterface $settings)
    {
    }

    /**
     * This service ensures that users cannot create servers, gift
     * resources or edit a servers resource limits if they do not
     * have sufficient resources in their account - or if the requested
     * amount goes over admin-defined limits.
     */
    public function handle(CreateServerRequest $request)
    {
        $this->checkUserResources($request);
        $this->checkResourceLimits($request);

        $this->checkDeploymentCost($request);
    }

    private function checkUserResources(CreateServerRequest $request)
    {
        $types = ['cpu', 'memory', 'disk', 'slots', 'ports', 'backups', 'databases'];

        foreach ($types as $type) {
            $value = DB::table('users')->where('id', $request->user()->id)->pluck('store_' . $type)->first();

            if ($value < $request->input($type)) {
                throw new DisplayException('您只有' . $value . ' ' . $type . ', 所以您不能部署此服务器。');
            }
        }
    }

    private function checkResourceLimits(CreateServerRequest $request)
    {
        $prefix = 'jexactyl::store:limit:';
        $types = ['cpu', 'memory', 'disk', 'slot', 'port', 'backup', 'database'];

        foreach ($types as $type) {
            $suffix = '';
            $limit = $this->settings->get($prefix . $type);

            if (in_array($type, ['slot', 'port', 'backup', 'database'])) {
                $suffix = 's';
            }

            $amount = $request->input($type .= $suffix);

            if ($limit < $amount) {
                throw new DisplayException('您不能部署 ' . $amount . ' ' . $type . ', 管理员设置了限制 ' . $limit);
            }
        }
    }

    /**
     * Ensures the user has enough credits in order to deploy to a given node.
     */
    private function checkDeploymentCost(CreateServerRequest $request)
    {
        $fee = Node::find($request->input('node'))->deploy_fee;

        if ($fee > $request->user()->store_balance) {
            throw new DisplayException('您没有足够的积分来部署到此节点，因为它的部署费用为 ' . $fee . ' 积分。');
        }
    }
}
