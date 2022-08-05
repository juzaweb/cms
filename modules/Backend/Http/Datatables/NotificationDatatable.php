<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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
                    return e(Arr::get($row->data, 'subject'));
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

    public function query($data): Builder
    {
        return $this->notificationRepository->query()->orderBy('id', 'desc');
    }
}
