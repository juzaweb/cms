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
use Juzaweb\Ecommerce\Models\ProductVariant;

class BulkUpdateCartRequest extends FormRequest
{
    public function rules()
    {
        return [
            '*.variant_id' => [
                'bail',
                'required',
                'integer',
                'min:1',
                Rule::modelExists(ProductVariant::class, 'id'),
            ],
            '*.quantity' => [
                'bail',
                'required',
                'integer',
                'min:0',
            ],
        ];
    }
}
