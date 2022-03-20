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
        $id = $attributes['id'] ?? null;

        $validator = Validator::make(
            $attributes,
            [
                'subject' => 'required',
                'code' => [
                    'required',
                    'max:50',
                    Rule::modelUnique(EmailTemplate::class, 'code')->ignore($id),
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
