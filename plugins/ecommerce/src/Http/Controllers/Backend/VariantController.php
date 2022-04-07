<?php

namespace Juzaweb\Ecommerce\Http\Controllers\Backend;

use Juzaweb\CMS\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Ecommerce\Models\Variant;

class VariantController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'ecom::backend.variant';

    protected function getDataTable(...$params)
    {
        return;
    }

    protected function validator(array $attributes, ...$params)
    {
        $validator = Validator::make(
            $attributes,
            [
                // Rules
            ]
        );

        return $validator;
    }

    protected function getModel(...$params)
    {
        return Inventory::class;
    }

    protected function getTitle(...$params)
    {
        return trans('ecom::content.variant');
    }
}
