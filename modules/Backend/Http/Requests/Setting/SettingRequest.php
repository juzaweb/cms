<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        $checkboxs = $this->getCheckboxSettings();
        $rules = collect($checkboxs)->mapWithKeys(
            function ($item) {
                return [
                    $item => 'required|in:0,1'
                ];
            }
        )->toArray();

        return $rules;
    }

    protected function prepareForValidation()
    {
        $checkboxs = $this->getCheckboxSettings();
        $input = [];
        foreach ($checkboxs as $checkbox) {
            if (!$this->has($checkbox)) {
                $input[$checkbox] = 0;
            }
        }

        $this->merge($input);
    }
}
