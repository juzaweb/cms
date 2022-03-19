<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Facades\Site;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Backend\Http\Datatables\EmailTemplateDataTable;
use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\Traits\ResourceController;

class EmailTemplateController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected $viewPrefix = 'cms::backend.email_template';

    protected function getDataTable(...$params)
    {
        return new EmailTemplateDataTable();
    }

    protected function validator(array $attributes, ...$params)
    {
        global $site;

        $id = $attributes['id'] ?? null;

        $validator = Validator::make(
            $attributes,
            [
                'subject' => 'required',
                'code' => [
                    'required',
                    'max:50',
                    Rule::unique('email_templates')
                        ->where(function ($q) use ($attributes, $site) {
                            return $q->where('code', $attributes['code'])
                                ->where('site_id', $site->id);
                        })
                        ->ignore($id),
                ],
            ]
        );

        return $validator;
    }

    protected function getModel(...$params)
    {
        return EmailTemplate::class;
    }

    protected function getTitle(...$params)
    {
        return trans('cms::app.email_templates');
    }

    protected function getDataForForm($model, ...$params)
    {
        $data = $this->DataForForm($model);
        $data['emailHooks'] = HookAction::getEmailHooks();
        return $data;
    }
}
