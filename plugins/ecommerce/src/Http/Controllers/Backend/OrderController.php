<?php

namespace Juzaweb\Ecommerce\Http\Controllers\Backend;

use Juzaweb\CMS\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Ecommerce\Http\Datatables\OrderDatatable;
use Juzaweb\Ecommerce\Models\Order;

class OrderController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'ecom::backend.order';

    protected function getDataTable(...$params)
    {
        return new OrderDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        $validator = Validator::make($attributes, [
            // Rules
        ]);

        return $validator;
    }

    protected function getModel(...$params)
    {
        return Order::class;
    }

    protected function getTitle(...$params)
    {
        return trans('ecom::content.orders');
    }
}
