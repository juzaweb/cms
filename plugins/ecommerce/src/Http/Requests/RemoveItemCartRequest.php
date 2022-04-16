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

class RemoveItemCartRequest extends FormRequest
{
    public function rules()
    {
        return [
            'variant_id' => [
                'bail',
                'integer',
                Rule::modelExists(ProductVariant::class, 'id'),
            ]
        ];
    }
}
