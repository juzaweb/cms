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
    protected string $editKey = 'code';

    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected string $viewPrefix = 'cms::backend.email_template';

    protected function getDataTable(...$params): EmailTemplateDataTable
    {
        return new EmailTemplateDataTable();
    }

    protected function validator(array $attributes, ...$params): \Illuminate\Contracts\Validation\Validator
    {
        $id = $attributes['id'] ?? null;

        return Validator::make(
            $attributes,
            [
                'subject' => ['required'],
                'body' => ['required'],
                'code' => [
                    'required',
                    'max:50',
                    Rule::modelUnique(
                        EmailTemplate::class,
                        'code',
                        function (Builder $q) use ($id) {
                            $q->where("{$q->getModel()->getTable()}.id", '!=', $id);
                        }
                    ),
                ],
            ]
        );
    }

    protected function getModel(...$params): string
    {
        return EmailTemplate::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('cms::app.email_templates');
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        $data['emailHooks'] = HookAction::getEmailHooks();
        return $data;
    }
}
