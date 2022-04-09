<?php

namespace Juzaweb\Notification\Http\Datatable;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Backend\Models\ManualNotification;
use Juzaweb\CMS\Support\SendNotification;
use Juzaweb\Notification\Jobs\SendNotification as SendNotificationJob;

class NotificationDatatable extends DataTable
{
    public function columns()
    {
        return [
            'subject' => [
                'label' => trans('cms::app.subject'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'method' => [
                'label' => trans('cms::app.via'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    if ($row->method) {
                        return $row->method;
                    }

                    return trans('cms::app.all');
                }
            ],
            'error' => [
                'label' => trans('cms::app.error'),
                'width' => '20%',
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    switch ($value) {
                        case 0:
                            return trans('cms::app.error');
                        case 1:
                            return trans('cms::app.sended');
                        case 2:
                            return trans('cms::app.pending');
                        case 3:
                            return trans('cms::app.sending');
                        case 4:
                            return trans('cms::app.unsent');
                    }

                    return '';
                }
            ]
        ];
    }

    public function rowActionsFormatter($value, $row, $index)
    {
        return view(
            'cms::backend.items.datatable_item',
            [
                'value' => $row->data['subject'],
                'row' => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => $this->currentUrl .'/'. $row->id . '/edit',
            ]
        )
            ->render();
    }

    public function query($data)
    {
        $query = ManualNotification::query();
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->orWhere('name', 'like', '%'. $keyword .'%');
                $q->orWhere('subject', 'like', '%'. $keyword .'%');
            });
        }

        if ($status = Arr::get($data, 'status')) {
            if (!is_null($status)) {
                $query->where('status', '=', $status);
            }
        }

        return $query;
    }

    public function actions()
    {
        return [
            'send' => trans('cms::app.send'),
            'delete' => trans('cms::app.delete'),
        ];
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                ManualNotification::destroy($ids);
                break;
            case 'send':
                ManualNotification::whereIn('id', $ids)
                    ->update([
                        'status' => 2
                    ]);

                $useMethod = config('notification.method');

                if (in_array($useMethod, ['sync', 'queue'])) {
                    foreach ($ids as $id) {
                        $notification = ManualNotification::find($id);
                        if (empty($notification)) {
                            continue;
                        }

                        switch ($useMethod) {
                            case 'sync':
                                (new SendNotification($notification))->send();
                                break;
                            case 'queue':
                                SendNotificationJob::dispatch(
                                    $notification
                                );
                                break;
                        }
                    }
                }
                break;
        }
    }
}
