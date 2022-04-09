<?php

namespace Juzaweb\Ecommerce\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Ecommerce\Http\Datatables\InventoryDatatable;
use Juzaweb\Ecommerce\Models\Inventory;

class InventoryController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'ecom::backend.inventory';

    protected function getDataTable(...$params)
    {
        return new InventoryDatatable();
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
        return Inventory::class;
    }

    protected function getTitle(...$params)
    {
        return trans('ecom::content.inventories');
    }
}
