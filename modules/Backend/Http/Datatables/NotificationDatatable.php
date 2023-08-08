<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Backend\Repositories\NotificationRepository;
use Juzaweb\CMS\Abstracts\DataTable;

class NotificationDatatable extends DataTable
{
    protected bool $searchable = false;

    protected NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    public function columns(): array
    {
        return [
            'subject' => [
                'label' => trans('cms::app.subject'),
                'formatter' => function ($value, $row, $index) {
                    $class = $row->read_at ? '': 'font-weight-bold';
                    return '<a href="'. route('admin.profile.notification', [$row->id]) .'" class="'. $class .'">'.
                        e($row->subject) .
                        '</a>';
                },
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return $value?->diffForHumans();
                }
            ]
        ];
    }

    public function actions(): array
    {
        $actions = parent::actions();

        $actions['viewed'] = trans('cms::app.mark_as_viewed');

        return $actions;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    $this->notificationRepository->delete($id);
                }
                break;
            case 'viewed':
                foreach ($ids as $id) {
                    $notify = $this->notificationRepository->find($id);

                    if (empty($notify->read_at)) {
                        $notify->update(['read_at' => now()]);
                    }
                }
                break;
        }
    }

    public function query($data): Builder
    {
        global $jw_user;

        $query = $this->notificationRepository->query();

        $query->where('notifiable_type', '=', 'Juzaweb\CMS\Models\User');

        $query->where('notifiable_id', '=', $jw_user->id);

        $query->orderBy('id', 'desc');

        return $query;
    }
}
