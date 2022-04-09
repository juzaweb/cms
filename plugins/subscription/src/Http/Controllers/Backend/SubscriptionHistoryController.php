<?php

namespace Juzaweb\Subscription\Http\Controllers\Backend;

use Juzaweb\CMS\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Subscription\Http\Datatables\SubscriptionHistoryDatatable;
use Juzaweb\Subscription\Models\SubscriptionHistory;

class SubscriptionHistoryController extends BackendController
{
    use ResourceController;

    protected $viewPrefix = 'subr::backend.subscription_history';

    protected function getDataTable(...$params)
    {
        return new SubscriptionHistoryDatatable();
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
        return SubscriptionHistory::class;
    }

    protected function getTitle(...$params)
    {
        return trans('subr::content.subscription_histories');
    }
}
