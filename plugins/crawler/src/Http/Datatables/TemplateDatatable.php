<?php

namespace Juzaweb\Crawler\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Crawler\Models\CrawTemplate;

class TemplateDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'name' => [
                'label' => trans('cms::app.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'actions' => [
                'label' => trans('cms::app.actions'),
                'width' => '20%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'crawler::template.components.actions_row',
                        compact('value', 'row', 'index')
                    )->render();
                }
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return $row->status;
                }
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
        $query = CrawTemplate::query();
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $builder) use ($keyword) {
                    $builder->orWhere(
                        'name',
                        'ilike',
                        '%'. $keyword .'%'
                    );
                }
            );
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                CrawTemplate::destroy($ids);
                break;
        }
    }
}
