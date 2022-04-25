<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Juzaweb\Backend\Http\Datatables\EmailTemplateDataTable;
use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\CMS\Traits\ResourceController;

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
                    Rule::modelUnique(EmailTemplate::class, 'code', function (Builder $q) use ($id) {
                        $q->where("{$q->getModel()->getTable()}.id", '!=', $id);
                    }),
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
