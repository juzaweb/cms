<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Juzaweb\CMS\Http\Controllers\BackendController;
use Juzaweb\Backend\Http\Datatables\UserDataTable;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\ResourceController;
use Illuminate\Support\Facades\Validator;

class UserController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
        afterSave as tAfterSave;
    }

    protected $viewPrefix = 'cms::backend.user';

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return \Illuminate\Support\Facades\Validator|array
     */
    protected function validator(array $attributes, ...$params)
    {
        $allStatus = array_keys(User::getAllStatus());

        return [
            'name' => 'required|string|max:250',
            'password' => [
                Rule::requiredIf(
                    function () use ($attributes) {
                        return empty($attributes['id']);
                    }
                ),
                'confirmed'
            ],
            'avatar' => 'nullable|string|max:150',
            'email' => [
                'required_if:id,',
                'email',
                'max:150',
                Rule::modelUnique(User::class, 'email'),
            ],
            'status' => 'required|in:' . implode(',', $allStatus),
        ];
    }

    /**
     * Get model resource
     *
     * @return string
     */
    protected function getModel(...$params)
    {
        return User::class;
    }

    /**
     * Get title resource
     *
     * @return string
     **/
    protected function getTitle(...$params)
    {
        return trans('cms::app.users');
    }

    /**
     * Get data table resource
     *
     * @return \Juzaweb\CMS\Abstracts\DataTable
     */
    protected function getDataTable(...$params)
    {
        return new UserDataTable();
    }

    protected function getDataForForm($model, ...$params)
    {
        $data = $this->DataForForm($model);
        $data['allStatus'] = User::getAllStatus();
        return $data;
    }

    protected function afterSave($data, $model, ...$params)
    {
        $this->tAfterSave($data, $model);

        do_action('user.after_save', $data, $model);
    }

    /**
     * After Save model
     *
     * @param array $data
     * @param \Juzaweb\CMS\Models\Model $model
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function beforeSave(&$data, &$model, ...$params)
    {
        if ($password = Arr::get($data, 'password')) {
            Validator::make(
                $data,
                [
                    'password' => 'required|string|max:32|min:8|confirmed',
                    'password_confirmation' => 'required|string|max:32|min:8',
                ],
                [],
                [
                    'password' => trans('cms::app.password'),
                    'password_confirmation' => trans('cms::app.confirm_password'),
                ]
            )->validate();

            $model->setAttribute('password', Hash::make($password));
        }

        do_action('user.before_save', $data, $model);
    }
}
