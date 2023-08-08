<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => [
                'required',
                'numeric'
            ],
            'star' => [
                'required',
                'numeric',
                'min:0',
                'max:5'
            ]
        ];
    }
}
