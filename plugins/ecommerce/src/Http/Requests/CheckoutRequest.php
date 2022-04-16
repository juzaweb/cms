<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Ecommerce\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\Ecommerce\Models\PaymentMethod;

class CheckoutRequest extends FormRequest
{
    public function rules()
    {
        global $jw_user;
        
        $rules = [];
        
        if (empty($jw_user)) {
            $rules['email'] = [
                'bail',
                'required',
                'email:rfc,dns',
                'max:150',
            ];
            
            $rules['name'] = [
                'bail',
                'required',
                'max:150',
            ];
        }
        
        $rules['notes'] = [
            'bail',
            'nullable',
            'max:500',
        ];
        
        $rules['payment_method_id'] = [
            'bail',
            'required',
            'integer',
            Rule::modelExists(PaymentMethod::class, 'id'),
        ];
        
        return $rules;
    }
}
