<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'current_password' => 'required|string',
            'password' => 'required|string|max:32|min:8|confirmed',
            'password_confirmation' => 'required|string|max:32|min:8',
        ];
    }

    public function attributes(): array
    {
        return [
            'current_password' => trans('cms::app.current_password'),
            'password' => trans('cms::app.password'),
            'password_confirmation' => trans('cms::app.confirm_password'),
        ];
    }
}
