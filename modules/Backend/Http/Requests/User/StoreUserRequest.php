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

use Illuminate\Validation\Rule;
use Juzaweb\CMS\Models\User;

class StoreUserRequest extends UserRequest
{
    public function rules(): array
    {
        $rules = parent::rules();
        $rules['email'] = [
            'bail',
            'required',
            'email',
            'max:150',
            Rule::modelUnique(User::class, 'email')
        ];
        $rules['password'] = [
            'bail',
            'required',
            'min:6',
            'max:32',
        ];
        return $rules;
    }
}
