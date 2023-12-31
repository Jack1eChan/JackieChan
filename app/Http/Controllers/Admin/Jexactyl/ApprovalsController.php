<?php

namespace Jexactyl\Http\Controllers\Admin\Jexactyl;

use Illuminate\View\View;
use Jexactyl\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Prologue\Alerts\AlertsMessageBag;
use Jexactyl\Http\Controllers\Controller;
use Jexactyl\Contracts\Repository\SettingsRepositoryInterface;
use Jexactyl\Http\Requests\Admin\Jexactyl\ApprovalFormRequest;

class ApprovalsController extends Controller
{
    /**
     * ApprovalsController constructor.
     */
    public function __construct(
        private AlertsMessageBag $alert,
        private SettingsRepositoryInterface $settings,
    ) {
    }

    /**
     * Render the Jexactyl referrals interface.
     */
    public function index(): View
    {
        $users = User::where('approved', false)->get();

        return view('admin.jexactyl.approvals', [
            'enabled' => $this->settings->get('jexactyl::approvals:enabled', false),
            'webhook' => $this->settings->get('jexactyl::approvals:webhook'),
            'users' => $users,
        ]);
    }

    /**
     * Updates the settings for approvals.
     *
     * @throws \Jexactyl\Exceptions\Model\DataValidationException
     * @throws \Jexactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function update(ApprovalFormRequest $request): RedirectResponse
    {
        foreach ($request->normalize() as $key => $value) {
            $this->settings->set('jexactyl::approvals:' . $key, $value);
        }

        $this->alert->success('修改成龙面板审批设置成功。')->flash();

        return redirect()->route('admin.jexactyl.approvals');
    }

    /**
     * Perform a bulk action for approval status.
     */
    public function bulkAction(Request $request, string $action): RedirectResponse
    {
        if ($action === 'approve') {
            User::query()->where('approved', false)->update(['approved' => true]);
        } else {
            try {
                User::query()->where('approved', false)->delete();
            } catch (DisplayException $ex) {
                throw new DisplayException('未能完成动作: ' . $ex->getMessage());
            }
        }

        $this->alert->success('所有用户被 ' . $action === 'approve' ? '批准 。' : '拒绝 。')->flash();

        return redirect()->route('admin.jexactyl.approvals');
    }

    /**
     * Approve an incoming approval request.
     */
    public function approve(Request $request, int $id): RedirectResponse
    {
        $user = User::where('id', $id)->first();
        $user->update(['approved' => true]);
        // This gives the user access to the frontend.

        $this->alert->success($user->username . ' 已被批准。')->flash();

        return redirect()->route('admin.jexactyl.approvals');
    }

    /**
     * Deny an incoming approval request.
     */
    public function deny(Request $request, int $id): RedirectResponse
    {
        $user = User::where('id', $id)->first();
        $user->delete();
        // While typically we should look for associated servers, there
        // shouldn't be any present - as the user has been waiting for approval.

        $this->alert->success($user->username . ' 已被拒绝。')->flash();

        return redirect()->route('admin.jexactyl.approvals');
    }
}
