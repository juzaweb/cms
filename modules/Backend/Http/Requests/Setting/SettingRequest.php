<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Juzaweb\CMS\Facades\HookAction;
use Illuminate\Validation\Rule;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        $checkboxs = HookAction::getConfigs()
            ->where('type', 'checkbox')
            ->whereIn('name', array_keys($this->input()))
            ->keys()
            ->toArray();

        $rules = collect($checkboxs)->mapWithKeys(
            function ($item) {
                return [
                    $item => 'nullable|in:1'
                ];
            }
        )->toArray();

        $rules['timezone'] = [
            'nullable',
            Rule::in(timezone_identifiers_list()),
        ];

        return $rules;
    }

    protected function prepareForValidation()
    {
        $checkboxs = HookAction::getConfigs()
            ->where('type', 'checkbox')
            ->whereIn('name', array_keys($this->input()))
            ->keys()
            ->toArray();
        $input = [];
        foreach ($checkboxs as $checkbox) {
            if (!$this->has($checkbox)) {
                $input[$checkbox] = 0;
            }
        }

        $this->merge($input);
    }
}
