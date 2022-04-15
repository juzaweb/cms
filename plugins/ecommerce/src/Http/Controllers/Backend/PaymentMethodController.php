<?php

namespace Juzaweb\Ecommerce\Http\Controllers\Backend;

use Illuminate\Validation\Rule;
use Juzaweb\CMS\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Ecommerce\Http\Datatables\PaymentMethodDatatable;
use Juzaweb\Ecommerce\Models\PaymentMethod;

class PaymentMethodController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected $viewPrefix = 'ecom::backend.payment_method';

    protected function getDataTable(...$params)
    {
        return new PaymentMethodDatatable();
    }

    protected function validator(array $attributes, ...$params)
    {
        $types = config('ecommerce.payment_methods');
        $types = array_keys($types);

        $validator = Validator::make(
            $attributes,
            [
                'type' => [
                    'required_if:id,',
                    Rule::in($types)
                ],
                'name' => [
                    'required'
                ]
            ]
        );

        return $validator;
    }

    protected function getModel(...$params)
    {
        return PaymentMethod::class;
    }

    protected function getTitle(...$params)
    {
        return trans('ecom::content.payment_methods');
    }

    protected function getDataForForm($model, ...$params)
    {
        $data = $this->DataForForm($model);
        $data['methods'] = trans('ecom::content.data.payment_methods');
        return $data;
    }

    protected function parseDataForSave(array $attributes, ...$params)
    {
        $attributes['active'] = $attributes['active'] ?? 0;

        return $attributes;
    }
}
