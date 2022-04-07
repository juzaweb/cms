<?php

namespace Juzaweb\Ecommerce\Http\Datatables;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Ecommerce\Models\PaymentMethod;

class PaymentMethodDatatable extends DataTable
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
                'label' => trans('ecom::content.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'type' => [
                'label' => trans('ecom::content.method'),
                'width' => '20%',
                'formatter' => function ($value, $row, $index) {
                    return trans("ecom::content.data.payment_methods.{$value}");
                }
            ],
            'active' => [
                'label' => trans('cms::app.status'),
                'width' => '10%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return view(
                        'cms::components.datatable.active',
                        compact('row')
                    )->render();
                }
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '20%',
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
        $query = PaymentMethod::select(
            [
                'id',
                'name',
                'type',
                'active',
                'created_at'
            ]
        );

        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->where('name', JW_SQL_LIKE, '%'. $keyword .'%');
            });
        }

        if ($type = Arr::get($data, 'type')) {
            $query->where('type', '=', $type);
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                PaymentMethod::destroy($ids);
                break;
        }
    }
}
