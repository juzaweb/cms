<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\CMS\Models\User;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'bail',
                'required',
                'email',
                'max:150',
                Rule::modelUnique(User::class, 'email')
            ],
            'password' => [
                'bail',
                'required',
                'min:6',
                'max:32',
                'confirmed'
            ],
        ];
    }
}
