<?php

namespace Jexactyl\Http\Controllers\Admin;

use Exception;
use Illuminate\View\View;
use Jexactyl\Models\DatabaseHost;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Jexactyl\Http\Controllers\Controller;
use Illuminate\View\Factory as ViewFactory;
use Jexactyl\Services\Databases\Hosts\HostUpdateService;
use Jexactyl\Http\Requests\Admin\DatabaseHostFormRequest;
use Jexactyl\Services\Databases\Hosts\HostCreationService;
use Jexactyl\Services\Databases\Hosts\HostDeletionService;
use Jexactyl\Contracts\Repository\DatabaseRepositoryInterface;
use Jexactyl\Contracts\Repository\LocationRepositoryInterface;
use Jexactyl\Contracts\Repository\DatabaseHostRepositoryInterface;

class DatabaseController extends Controller
{
    /**
     * DatabaseController constructor.
     */
    public function __construct(
        private AlertsMessageBag $alert,
        private DatabaseHostRepositoryInterface $repository,
        private DatabaseRepositoryInterface $databaseRepository,
        private HostCreationService $creationService,
        private HostDeletionService $deletionService,
        private HostUpdateService $updateService,
        private LocationRepositoryInterface $locationRepository,
        private ViewFactory $view
    ) {
    }

    /**
     * Display database host index.
     */
    public function index(): View
    {
        return $this->view->make('admin.databases.index', [
            'locations' => $this->locationRepository->getAllWithNodes(),
            'hosts' => $this->repository->getWithViewDetails(),
        ]);
    }

    /**
     * Display database host to user.
     *
     * @throws \Jexactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function view(int $host): View
    {
        return $this->view->make('admin.databases.view', [
            'locations' => $this->locationRepository->getAllWithNodes(),
            'host' => $this->repository->find($host),
            'databases' => $this->databaseRepository->getDatabasesForHost($host),
        ]);
    }

    /**
     * Handle request to create a new database host.
     *
     * @throws \Throwable
     */
    public function create(DatabaseHostFormRequest $request): RedirectResponse
    {
        try {
            $host = $this->creationService->handle($request->normalize());
        } catch (\Exception $exception) {
            if ($exception instanceof \PDOException || $exception->getPrevious() instanceof \PDOException) {
                $this->alert->danger(
                    sprintf('连接主机或执行查询时出现错误: "%s"', $exception->getMessage())
                )->flash();

                return redirect()->route('admin.databases')->withInput($request->validated());
            } else {
                throw $exception;
            }
        }

        $this->alert->success('成功在系统上创建了一个新的数据库主机。')->flash();

        return redirect()->route('admin.databases.view', $host->id);
    }

    /**
     * Handle updating database host.
     *
     * @throws \Throwable
     */
    public function update(DatabaseHostFormRequest $request, DatabaseHost $host): RedirectResponse
    {
        $redirect = redirect()->route('admin.databases.view', $host->id);

        try {
            $this->updateService->handle($host->id, $request->normalize());
            $this->alert->success('数据库主机修改成功。')->flash();
        } catch (\Exception $exception) {
            // Catch any SQL related exceptions and display them back to the user, otherwise just
            // throw the exception like normal and move on with it.
            if ($exception instanceof \PDOException || $exception->getPrevious() instanceof \PDOException) {
                $this->alert->danger(
                    sprintf('连接主机或执行查询时出现错误: "%s"', $exception->getMessage())
                )->flash();

                return $redirect->withInput($request->normalize());
            } else {
                throw $exception;
            }
        }

        return $redirect;
    }

    /**
     * Handle request to delete a database host.
     *
     * @throws \Jexactyl\Exceptions\Service\HasActiveServersException
     */
    public function delete(int $host): RedirectResponse
    {
        $this->deletionService->handle($host);
        $this->alert->success('所请求的数据库主机已从系统中删除。')->flash();

        return redirect()->route('admin.databases');
    }
}
