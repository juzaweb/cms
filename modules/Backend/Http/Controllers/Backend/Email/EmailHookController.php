<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\Backend\Email;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\Backend\Http\Datatables\Email\EmailHookDataTable;
use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Traits\ResourceController;

class EmailHookController extends PageController
{
    protected string $viewPrefix = 'cms::backend.email_hook';

    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected function validator(array $attributes, ...$params): ValidatorContract
    {
        return Validator::make(
            $attributes,
            [
                'subject' => ['required'],
                'email_hook' => ['required'],
                'body' => ['required'],
            ]
        );
    }

    protected function getModel(...$params): string
    {
        return EmailTemplate::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('cms::app.email_hooks');
    }

    protected function getDataForForm($model, ...$params): array
    {
        $data = $this->DataForForm($model);
        $data['emailHooks'] = HookAction::getEmailHooks();
        return $data;
    }

    protected function parseDataForSave(array $attributes, ...$params): array
    {
        $attributes['to_sender'] = Arr::get($attributes, 'to_sender', 0);
        $attributes['active'] = Arr::get($attributes, 'active', 0);

        return $attributes;
    }

    protected function afterSave($data, $model, ...$params): void
    {
        $model->users()->sync(Arr::get($data, 'to_users', []));
    }

    protected function getDataTable(...$params): EmailHookDataTable
    {
        return new EmailHookDataTable();
    }
}
