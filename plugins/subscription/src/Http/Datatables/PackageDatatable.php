<?php

namespace Juzaweb\Subscription\Http\Datatables;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Subscription\Models\Package;

class PackageDatatable extends DataTable
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
                'label' => trans('subr::content.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'price' => [
                'label' => trans('subr::content.price'),
                'width' => '15%',
                'align' => 'center',
            ],
            'actions' => [
                'label' => trans('subr::content.actions'),
                'width' => '25%',
                'align' => 'center',
                'sortable' => false,
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'subr::backend.package.components.action_item',
                        compact(
                            'row'
                        )
                    )->render();
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
        $query = Package::query();

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', 'ilike', '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Package::destroy($ids);
                break;
        }
    }
}
