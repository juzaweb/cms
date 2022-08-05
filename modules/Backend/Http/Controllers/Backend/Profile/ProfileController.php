<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Profile;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Datatables\NotificationDatatable;
use Juzaweb\Backend\Http\Requests\User\ProfileUpdateRequest;
use Juzaweb\Backend\Repositories\NotificationRepository;
use Juzaweb\CMS\Http\Controllers\BackendController;

class ProfileController extends BackendController
{
    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function index(): View
    {
        global $jw_user;

        $title = trans('cms::app.profile');

        $dataTable = $this->getNotificationDataTable();

        return view(
            'cms::backend.profile.index',
            compact('title', 'jw_user', 'dataTable')
        );
    }

    public function notificationDatatable(Request $request): \Illuminate\Http\JsonResponse
    {
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = (int) $request->get('limit', 20);

        $table = $this->getNotificationDataTable();
        $query = $table->query($request->all());
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);

        $count = $query->count();
        $rows = $query->get();

        $results = [];
        $columns = $table->columns();

        foreach ($rows as $index => $row) {
            $columns['id'] = $row->id;
            foreach ($columns as $col => $column) {
                if (! empty($column['formatter'])) {
                    $results[$index][$col] = $column['formatter'](
                        $row->{$col} ?? null,
                        $row,
                        $index
                    );
                } else {
                    $results[$index][$col] = $row->{$col};
                }
            }
        }

        return response()->json(
            [
                'total' => $count,
                'rows' => $results,
            ]
        );
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        $user->update($request->only(['name', 'avatar']));

        //
    }

    public function notification($id): View|\Illuminate\Http\RedirectResponse
    {
        $notification = $this->notificationRepository->find($id);

        if ($notification->url) {
            return redirect()->to($notification->url);
        }

        $title = $notification->subject;

        return view(
            'cms::backend.profile.notification',
            compact('title', 'notification')
        );
    }

    private function getNotificationDataTable()
    {
        $dataTable = app(NotificationDatatable::class);
        $dataTable->setDataUrl(action([static::class, 'notificationDatatable']));
        return $dataTable;
    }
}
