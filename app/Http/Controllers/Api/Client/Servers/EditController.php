<?php

namespace Jexactyl\Http\Controllers\Api\Client\Servers;

use Jexactyl\Models\Server;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Jexactyl\Exceptions\DisplayException;
use Jexactyl\Services\Servers\ServerEditService;
use Jexactyl\Http\Controllers\Api\Client\ClientApiController;
use Jexactyl\Http\Requests\Api\Client\Servers\EditServerRequest;

class EditController extends ClientApiController
{
    /**
     * PowerController constructor.
     */
    public function __construct(private ServerEditService $editService)
    {
        parent::__construct();
    }

    /**
     * Edit a server's resource limits.
     *
     * @throws DisplayException
     */
    public function index(EditServerRequest $request, Server $server): JsonResponse
    {
        if ($this->settings->get('jexactyl::renewal:editing') != 'true') {
            throw new DisplayException('修改服务器功能已禁用。');
        }

        if ($request->user()->id != $server->owner_id) {
            throw new DisplayException('您不是此服务器的所有者，因此无法编辑资源。');
        }

        $this->editService->handle($request, $server);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
