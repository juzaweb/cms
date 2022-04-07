<?php

namespace Juzaweb\Subscription\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Subscription\Models\SubscriptionHistory;

class SubscriptionHistoryDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'user_name' => [
                'label' => trans('subr::content.user'),
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    return $row->user->name;
                }
            ],
            'method' => [
                'label' => trans('subr::content.method'),
                'width' => '15%',
                'align' => 'center',
            ],
            'amount' => [
                'label' => trans('subr::content.amount'),
                'width' => '15%',
                'align' => 'center',
            ],
            'module' => [
                'label' => trans('subr::content.module'),
                'width' => '15%',
                'align' => 'center',
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
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
        $query = SubscriptionHistory::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                // $q->where('title', 'ilike', '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                SubscriptionHistory::destroy($ids);
                break;
        }
    }
}
