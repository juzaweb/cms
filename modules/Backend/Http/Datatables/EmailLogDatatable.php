<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Facades\Site;
use Juzaweb\Jobs\SendEmailJob;
use Juzaweb\Backend\Models\EmailList;
use Juzaweb\CMS\Support\SendEmail;

class EmailLogDatatable extends DataTable
{
    protected $sortName = 'updated_at';

    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'subject' => [
                'label' => trans('cms::app.subject'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return $row->getSubject();
                }
            ],
            'content' => [
                'label' => trans('cms::app.content'),
                'formatter' => function ($value, $row, $index) {
                    return $row->getBody();
                }
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '10%',
                'formatter' => function ($value, $row, $index) {
                    switch ($value) {
                        case EmailList::STATUS_SUCCESS:
                            return '<span class="text-success">'. trans('cms::app.sended') .'</span>';
                            break;
                        case EmailList::STATUS_PENDING:
                            return '<span class="text-warning">'. trans('cms::app.pending') .'</span>';
                            break;
                        case EmailList::STATUS_CANCEL:
                            return '<span class="text-success">'.trans('cms::app.cancel').'</span>';
                            break;
                        default:
                            return '<span class="text-danger">'.trans('cms::app.error').'</span>';
                            break;
                    }
                }
            ],
            'updated_at' => [
                'label' => trans('cms::app.updated_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->updated_at);
                },
            ],
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = EmailList::with(['template']);

        if ($search = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('subject', JW_SQL_LIKE, '%'. $search .'%');
                $q->orWhere('content', JW_SQL_LIKE, '%'. $search .'%');
            });
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function actions()
    {
        return [
            'delete' => trans('cms::app.delete'),
            'resend' => trans('cms::app.resend'),
            'cancel' => trans('cms::app.cancel'),
        ];
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                EmailList::destroy($ids);
                break;
            case 'resend':
                $method = config('juzaweb.email.method');
                $status = EmailList::STATUS_PENDING;

                $emailLists = EmailList::whereIn('id', $ids)
                    ->whereIn('status', [
                        EmailList::STATUS_PENDING,
                        EmailList::STATUS_ERROR
                    ])
                    ->get();

                foreach ($emailLists as $emailList) {
                    switch ($method) {
                        case 'sync':
                            (new SendEmail($emailList))->send();
                            break;
                        case 'queue':
                            SendEmailJob::dispatch($emailList);
                            break;
                    }

                    $emailList->update([
                        'status' => $status
                    ]);
                }

                break;
            case 'cancel':
                $status = $action;
                EmailList::whereIn('id', $ids)
                    ->whereIn('status', [
                        EmailList::STATUS_PENDING,
                        EmailList::STATUS_ERROR
                    ])
                    ->update([
                        'status' => $status
                    ]);
        }
    }
}
