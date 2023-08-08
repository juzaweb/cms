<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\CMS\Models\User;

class ForgotPasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::modelExists(User::class, 'email', fn($q) => $q->active())
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'email.exists' => trans('cms::app.email_does_not_exists'),
        ];
    }
}
