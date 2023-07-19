<?php

namespace Jexactyl\Services\Servers;

use Jexactyl\Models\Server;
use Jexactyl\Exceptions\DisplayException;
use Jexactyl\Http\Requests\Api\Client\ClientApiRequest;
use Jexactyl\Contracts\Repository\SettingsRepositoryInterface;

class ServerRenewalService
{
    private SuspensionService $suspensionService;
    private SettingsRepositoryInterface $settings;

    /**
     * ServerRenewalService constructor.
     */
    public function __construct(
        SuspensionService $suspensionService,
        SettingsRepositoryInterface $settings
    ) {
        $this->settings = $settings;
        $this->suspensionService = $suspensionService;
    }

    /**
     * Renews a server.
     *
     * @throws DisplayException
     */
    public function handle(ClientApiRequest $request, Server $server): Server
    {
        $user = $request->user();
        $cost = $this->settings->get('jexactyl::renewal:cost', 200);

        if ($user->store_balance < $cost) {
            throw new DisplayException('您没有足够的积分来续订服务器。');
        }

        try {
            $user->update(['store_balance' => $user->store_balance - $cost]);
            $server->update(['renewal' => $server->renewal + $this->settings->get('jexactyl::renewal:default', 7)]);
        } catch (DisplayException $ex) {
            throw new DisplayException('尝试续订服务器时发生意外错误。');
        }

        if ($server->status == 'suspended' && $server->renewal >= 0) {
            $this->suspensionService->toggle($server, 'unsuspend');
        }

        return $server->refresh();
    }
}
