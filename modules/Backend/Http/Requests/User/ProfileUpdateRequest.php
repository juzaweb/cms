<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:150'
            ],
            'avatar' => 'nullable|string|max:150',
            'password' => 'required|string|max:32|min:8|confirmed',
            'password_confirmation' => 'required|string|max:32|min:8',
        ];
    }

    public function attributes(): array
    {
        return [
            'password' => trans('cms::app.password'),
            'password_confirmation' => trans('cms::app.confirm_password'),
        ];
    }
}
