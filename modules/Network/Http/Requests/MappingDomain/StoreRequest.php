<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Http\Requests\MappingDomain;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\Network\Models\DomainMapping;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'domain' => [
                'bail',
                'required',
                'max:100',
                'min:4',
                "regex:/(^[a-z0-9\-\.]+)/",
                Rule::modelUnique(
                    DomainMapping::class,
                    'domain'
                )
            ],
        ];
    }
}
