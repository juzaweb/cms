<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Juzaweb\Backend\Events\RegisterSuccessful;
use Juzaweb\CMS\Models\User;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => [
                'bail',
                'required',
                'min:5',
            ],
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

        if (get_config('captcha')) {
            $rules['g-recaptcha-response'] = 'bail|required|recaptcha';
        }

        return $rules;
    }

    public function createUserFromRequest(): User
    {
        do_action('register.handle', $this);
        $password = $this->post('password');

        DB::beginTransaction();
        try {
            $user = new User();

            $user->fill($this->safe()->only(['name', 'email']));

            $user->setAttribute('password', Hash::make($password));

            $user->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        event(new RegisterSuccessful($user));

        do_action('register.success', $user);

        return $user;
    }
}
