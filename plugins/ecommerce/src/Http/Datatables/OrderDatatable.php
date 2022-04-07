<?php

namespace Juzaweb\Ecommerce\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Ecommerce\Models\Order;

class OrderDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'code' => [
                'label' => trans('ecom::content.code'),
            ],
            'name' => [
                'label' => trans('ecom::content.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'phone' => [
                'label' => trans('ecom::content.phone'),
            ],
            'email' => [
                'label' => trans('ecom::content.email'),
            ],
            'total' => [
                'label' => trans('ecom::content.total'),
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
        $query = Order::select([
            'code',
            'name',
            'email',
            'phone',
            'total',
            'created_at',
        ]);

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', JW_SQL_LIKE, '%'. $keyword .'%');
                $q->orWhere('email', JW_SQL_LIKE, '%'. $keyword .'%');
                $q->orWhere('phone', JW_SQL_LIKE, '%'. $keyword .'%');
            });
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                Order::destroy($ids);
                break;
        }
    }
}
